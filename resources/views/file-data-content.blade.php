<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default animated fadeIn">
            <div class="panel-heading">
                Bank Transactions From CSV
            </div>
            <div class="panel-body">
                <div class="table-responsive" id="bankTransactionsPlaceholder">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-BankTransactions">
                        <thead>
                            <tr style="display:none;">
                                @for($i = 0; $i < 5; $i++)
                                    <th>&nbsp;</th>
                                @endfor
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>TransactionNumber</th>
                                <th>Valid Transaction?</th>
                                <th>CustomerNumber</th>
                                <th>Reference</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data as $rowNumber => $rowData)
                                <tr>
                                    <td>{{ $rowData['Date']; }}</td>
                                    <td>{{ $rowData['TransactionNumber'] }}</td>
                                    <td>{{ $rowData['TransactionValidation'] }}</td>
                                    <td>{{ $rowData['CustomerNumber'] }}</td>
                                    <td>{{ $rowData['Reference'] }}</td>
                                    <td style="color:{{ $rowData['AmountType'] == 'Credit' ? 'green' : 'red'}}">{{ $rowData['Amount'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

