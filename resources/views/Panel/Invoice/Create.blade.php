@extends('Panel.Layouts.Master')

@section('title', 'ایجاد صورتحساب جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">ایجاد صورتحساب جدید</h4>
                    
                    <form id="searchForm" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="doctor_id">پزشک</label>
                                    <select class="form-control" id="doctor_id" name="doctor_id" required>
                                        <option value="">انتخاب کنید</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="from_date">از تاریخ</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="to_date">تا تاریخ</label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">جستجو</button>
                            </div>
                        </div>
                    </form>

                    <form id="invoiceForm" action="{{ route('panel.invoices.store') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="doctor_id" id="invoice_doctor_id">
                        
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th>تاریخ عمل</th>
                                        <th>نوع عمل</th>
                                        <th>مبلغ</th>
                                    </tr>
                                </thead>
                                <tbody id="surgeries-list"></tbody>
                                <tfoot class="d-none" id="table-footer">
                                    <tr>
                                        <td colspan="3" class="text-start">جمع کل:</td>
                                        <td id="total-amount" class="text-center">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">ایجاد صورتحساب</button>
                            <a href="{{ route('panel.invoices.index') }}" class="btn btn-secondary">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const invoiceForm = document.getElementById('invoiceForm');
    const surgeriesList = document.getElementById('surgeries-list');
    const tableFooter = document.getElementById('table-footer');
    const totalAmountCell = document.getElementById('total-amount');
    const selectAllCheckbox = document.getElementById('select-all');
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(searchForm);
        document.getElementById('invoice_doctor_id').value = formData.get('doctor_id');
        
        fetch(`{{ route('panel.invoices.search-surgeries') }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(surgeries => {
            surgeriesList.innerHTML = '';
            if (surgeries.length > 0) {
                surgeries.forEach(surgery => {
                    const price = surgery.doctors[0]?.pivot?.price || 0;
                    surgeriesList.innerHTML += `
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="surgery_ids[]" value="${surgery.id}" class="surgery-checkbox" data-price="${price}">
                            </td>
                            <td class="text-center">${surgery.surgery_date}</td>
                            <td class="text-center">${surgery.surgery_types.map(type => type.title).join(', ')}</td>
                            <td class="text-center">${price.toLocaleString()}</td>
                        </tr>
                    `;
                });
                invoiceForm.classList.remove('d-none');
                tableFooter.classList.remove('d-none');
            } else {
                surgeriesList.innerHTML = '<tr><td colspan="4" class="text-center">هیچ عملی یافت نشد</td></tr>';
                invoiceForm.classList.add('d-none');
                tableFooter.classList.add('d-none');
            }
        });
    });

    selectAllCheckbox.addEventListener('change', function() {
        document.querySelectorAll('.surgery-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateTotal();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('surgery-checkbox')) {
            updateTotal();
        }
    });

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.surgery-checkbox:checked').forEach(checkbox => {
            total += parseInt(checkbox.dataset.price) || 0;
        });
        totalAmountCell.textContent = total.toLocaleString();
    }
});
</script>
@endpush 