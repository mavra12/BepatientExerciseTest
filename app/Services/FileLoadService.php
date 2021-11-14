<?php
namespace App\Services;

use DateTime;

class FileLoadService
{
    private $fileMapping;
    private $data;
    private $validchar;
    private $amountType;

    /**
     * Create a new FileLoadService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setFileMapping();
        $this->amountType = "";
        $this->data = [];
        $this->validChars = ['2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 
            'D', 'E', 'F', 'G', 'H', 'J', 'K','L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 
            'U', 'V', 'W', 'X', 'Y', 'Z'];
    }

    /**
     * File mapping
     *
     * @return void
     */
    private function setFileMapping(): void
    {
        /**
         * field: name of the field in the file
         * validation: type of validation which will be used on the $this->validateColumn() method
         */
        $this->fileMapping = [
            ['field' => 'Date', 'validation' => 'date'],
            ['field' => 'TransactionNumber', 'validation' => 'transaction'],
            ['field' => 'CustomerNumber', 'validation' => 'numeric'],
            ['field' => 'Reference', 'validation' => 'string'],
            ['field' => 'Amount', 'validation' => 'currency']
        ];

        // Columns mapping
        $this->columnDescriptions = [];
        for($i = 'A'; $i <= 'E'; $i++) {
            $this->columnDescriptions[] = $i;
        }
    }

    /**
     * Validate data based on file mapping and validation type
     *
     * @param mixed $fieldValue
     * @param int $rowNumber
     * @param string $validationType
     * @return mixed
     */
    private function validateColumn($fieldValue, int $rowNumber, string $validationType = null)
    {
        $fieldValuewithValidation = $fieldValue;

        if (empty($fieldValue)) {
            $fieldValuewithValidation .=  "invalid value";
            return null;
        }

        switch ($validationType) {
            case 'date':
                try {
                    $date = DateTime::createFromFormat('Y-m-d H:iA', $fieldValue);
                    
                    if (!$date) {
                        $fieldValuewithValidation .= " ( Invalid )";
                    }
                } catch (\Exception $e) {
                    $fieldValuewithValidation .= " ( Invalid )";
                }
                break;
            case 'numeric':
                if (!is_numeric($fieldValue)) {
                    $fieldValuewithValidation .= " ( Invalid )";
                }
                break;
            case 'string':
                if (!is_string($fieldValue)) {
                    $fieldValuewithValidation .= " ( Invalid )";
                }
                break;
            case 'transaction':
                $this->data[$rowNumber]["TransactionValidation"] = "No";
                if ($this->VerifyKey($fieldValue)) {
                    $this->data[$rowNumber]["TransactionValidation"] = "Yes";
                }
                break;
            case 'currency':
                $this->data[$rowNumber]["AmountType"] =  $fieldValue > 0 ? "Credit" : "Debit";
                if (!$this->isCurrency($fieldValue)) {
                    $fieldValuewithValidation .= " ( Invalid )";
                }
                break;
            default:
                if (isset($this->$validationType) && is_array($this->$validationType) && !in_array($fieldValue, $this->$validationType)) {
                    $fieldValuewithValidation  .= "Invalid Value";
                }
                break;
        }
        return $fieldValuewithValidation;
    }

    /**
     * Set values based on file mapping
     *
     * @param array $rowData
     * @param int $rowNumber
     * @return void
     */
    private function processRow(array $rowData, int $rowNumber): void
    {
        foreach ($this->fileMapping as $column => $columnInfo) {
            $fieldValue = trim($rowData[$column]);
            $this->data[$rowNumber][$columnInfo['field']] = $this->validateColumn($fieldValue, $rowNumber, $columnInfo['validation']);
        }
    }

    /**
     * Read and process file
     *
     * @param object $file
     * @return bool
     */
    public function processFile(object $file): bool
    {
        $fp = fopen($file, 'r');

        $rowNumber = 2;
        $firstLine = true;
        while ($rowData = fgetcsv($fp)) {
            if($firstLine) { 
                $firstLine = false; continue; 
            }
            $this->processRow($rowData, $rowNumber);
            $rowNumber++;
        }
        return true;
    }

    /**
     * Data getter
     *
     * @return array
     */
    public function getData(): array
    {
        if (empty($this->data)) {
            return false;
        }
        return $this->data;
    }

    /**
     * Data sort by Date column
     *
     * @return array
     */
    public function sortDataByDate($dataArray): array
    {
        if (!empty($dataArray)) {    
            $dateColumn = array_column($dataArray, 'Date');
            array_multisort(array_map('strtotime',($dateColumn)), SORT_ASC, $dataArray);
        }
        return $dataArray;
    }

    /**
     * Check if currency is valid or not
     *
     * @param string $input
     * @return bool
     */
    private function isCurrency(string $input): bool
    {
        $currencyValidation = preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $input);
        return $currencyValidation;
    }

    /**
     * 
     * Verify Transaction code
     * 
     * @param string $key
     * @return bool
     */
    private function VerifyKey(string $key)
    {
        if (strlen($key) != 10) {
            return false;
        }
        $checkDigit = $this->GenerateCheckCharacter(substr(strtoupper($key), 0, 9));
        return $key[9] == $checkDigit;
    }

    /**
     * Implementation of algorithm for check digit.
     * 
     * @param string $input
     * @return char
     */
    private function GenerateCheckCharacter(string $input)
    {
        $factor = 2;
        $sum = 0;
        $n = sizeof($this->validChars);
        // Starting from the right and working leftwards is easier since
        // the initial "factor" will always be "2"
        for ($i = strlen($input) - 1; $i >= 0; $i--) {
            $codePoint = array_search($input[$i], $this->validChars);
            $addend = $factor * $codePoint;
            // Alternate the "factor" that each "codePoint" is multiplied by
            $factor = ($factor == 2) ? 1 : 2;
            // Sum the digits of the "addend" as expressed in base "n"
            $addend = ($addend / $n) + ($addend % $n);
            $sum += $addend;
        }
        // Calculate the number that must be added to the "sum"
        // to make it divisible by "n"
        $remainder = $sum % $n;
        $checkCodePoint = ($n - $remainder) % $n;
        return $this->validChars[$checkCodePoint];
    }
}
