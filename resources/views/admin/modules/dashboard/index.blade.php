@extends('admin.layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
  @if(!session()->has('memo_viewed'))
    <memo-alert inline-template :count="{{ $memosCount }}">
      @include('admin.modules.dashboard.modal.memo-alert')
    </memo-alert>
    @php
      session()->push('memo_viewed', true);
    @endphp
  @endif
  <div class="row dashboard-content">
    <div class="col-xsmall-1">
      <div class="list-wrap">
        <div class="list-content mb-15">
          <div class="link">
            <a href="#">
              <img class="height-25" src="{{ asset('images/dashboard/ic_printer.png') }}" alt="Printer">
              <span>Printer Control</span>
            </a>
          </div>
        </div>
        <div class="list-content mb-15">
          <div class="link">
            <a href="#">
              <img class="height-25" src="{{ asset('images/dashboard/ic_page_display.png') }}" alt="Page & Display">
              <span>Page & Display</span>
            </a>
          </div>
        </div>
        <div class="list-content mb-15">
          <div class="link">
            <a href="#">
              <img class="height-25" src="{{ asset('images/dashboard/ic_function-keys.png') }}" alt="Function Keys">
              <span>Function Keys</span>
            </a>
          </div>
        </div>
        <div class="list-content mb-15">
          <div class="link">
            <a href="/setup">
              <img class="height-25" src="{{ asset('images/dashboard/ic_setup.png') }}" alt="Set up">
              <span>Set-up</span>
            </a>
          </div>
        </div>
        <div class="list-content mb-15">
          <div class="link">
            <a href="/security">
              <img class="height-25" src="{{ asset('images/dashboard/ic_security-users.png') }}" alt="Security Users">
              <span>Security Users</span>
            </a>
          </div>
        </div>
        <div class="list-content arrow arrow-bottom-right mb-5" style="padding-top: 5px;">
          <div class="link">
            <a href="/terms">
              <img class="height-35" src="{{ asset('images/dashboard/ic_terms.png') }}" alt="Terms">
              <span>Terms</span>
            </a>
          </div>
        </div>
        <div class="list-content arrow arrow-right-small mb-5" style="padding-top: 0px">
          <div class="link">
            <a href="/clients">
              <img class="height-30" src="{{ asset('images/dashboard/ic_clients.png') }}" alt="Clients">
              <span>Clients</span>
            </a>
          </div>
        </div>
        <div class="list-content arrow arrow-up-right templates  mb-5" style="padding-top: 0px;">
          <div class="link">
            <a href="/costing-templates">
              <img class="height-30" src="{{ asset('images/dashboard/ic_test.png') }}" alt="Costing Templates">
              <span>Costing Templates</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xsmall-1">
      <div class="list-wrap">
        <div class="list-content arrow arrow-down">
          <div class="link">
            <a href="{{ route('admin.products.index') }}">
              <img src="{{ asset('images/dashboard/ic_product-prices.png') }}" alt="Products Prices Sampling">
              <span>Products Prices Sampling</span>
            </a>
          </div>
        </div>
        <div class="list-content arrow arrow-down-large">
          <div class="link">
            <a href="#">
              <img src="{{ asset('images/dashboard/ic_samples-on-loan.png') }}" alt="Samples on Loan">
              <span>Samples on Loan</span>
            </a>
          </div>
        </div>
        <div class="list-content quotes arrow arrow-right-medium">
          <div class="link text-blue" data-text="Work in progress">
            <a href="{{ route('admin.quotes.index') }}" class="text-yellow">
              <img src="{{ asset('images/dashboard/ic_quotes.png') }}" alt="Quotes">
              <span class="text-yellow">Quotes</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xsmall-9">
      <div class="list-wrap">
        <div class="row">
          <div class="col-xsmall-2" style="margin-top: 115px">
            <div class="list-content arrow arrow-down">
              <div class="link">
                <a href="{{ route('admin.accounts.index') }}">
                  <img src="{{ asset('images/dashboard/ic_chart-of-accounts.png') }}" alt="Chart of Accounts">
                  <span>Chart of Accounts</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content arrow arrow-left-medium">
              <div class="link">
                <a href="{{ route('admin.suppliers.index') }}">
                  <img src="{{ asset('images/dashboard/ic_suppliers.png') }}" alt="Suppliers">
                  <span>Suppliers</span>
                </a>
              </div>
            </div>
          </div>
        </div>
          <div class="row">
          <div class="col-xsmall-2">
            <div class="list-content">
              <div class="link">
                <a href="#">
                  <img src="{{ asset('images/dashboard/ic_general-ledger.png') }}" alt="General Ledger">
                  <span>General Ledger</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content arrow arrow-left">
              <div class="link">
                <a href="/cash-book">
                  <img src="{{ asset('images/dashboard/ic_cash-book.png') }}" alt="Cash Book">
                  <span>Cash Book</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2 remittance">
            <div class="list-content arrow arrow-left arrow-up-left-large ">
              <div class="link">
                <a href="/cheque-butt">
                  <img src="{{ asset('images/dashboard/ic_remittance.png') }}" alt="Remittances">
                  <span>Remittances</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xsmall-2">
            <div class="list-content billing arrow arrow-up-small arrow-bottom-up">
              <div class="link">
                <a href="/billings">
                  <img src="{{ asset('images/dashboard/ic_billing.png') }}" alt="Billing">
                  <span>Billing</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content installation arrow arrow-bottom-up" style="padding-top: 30px;">
              <div class="link">
                <a href="{{ route('admin.installation-complaints.index') }}">
                  <img src="{{ asset('images/dashboard/ic_installation-complaints.png') }}"
                       alt="Installation Complaints">
                  <span>Installation Complaints</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content arrow arrow-up-right contractors">
              <div class="link">
                <a href="{{ route('admin.contractors.index') }}">
                  <img src="{{ asset('images/dashboard/ic_contractors.png') }}" alt="Contractors">
                  <span>Contractors</span>
                </a>
              </div>
            </div>
          </div>

          <div class="col-xsmall-2">
            <div class="list-content arrow arrow-up-right payables">
              <div class="link">
                <a href="/payables">
                  <img src="{{ asset('images/dashboard/ic_payables.png') }}" alt="Payables">
                  <span>Payables</span>
                </a>
              </div>
            </div>
          </div>

          <div class="col-xsmall-2">
            <div class="list-content delivered-orders arrow arrow-up-right">
              <div class="link">
                <a href="/delivered-orders">
                  <img src="{{ asset('images/dashboard/ic_delivered-orders.png') }}" alt="Delivered Orders">
                  <span>Delivered Orders</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xsmall-2"></div>
          <div class="col-xsmall-2">
            <div class="list-content jobs arrow arrow-up arrow-bottom-up" style="margin-top: -35px;">
              <div class="link text-yellow">
                <a href="{{ route('admin.jobs.index') }}">
                  <img src="{{ asset('images/dashboard/ic_jobs.png') }}" alt="Jobs">
                  <span class="text-yellow">Jobs</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content bookings arrow arrow-up arrow-right" style="margin-top: -30px;">
              <div class="link">
                <a href="{{ route('admin.bookings.index') }}">
                  <img src="{{ asset('images/dashboard/ic_bookings.png') }}" alt="Bookings">
                  <span>Bookings</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content purchase-order arrow arrow-up" style="margin-top: -25px;">
              <div class="link">
                <a href="/current-orders">
                  <img src="{{ asset('images/dashboard/ic_purchase-orders.png') }}" alt="Purchase Orders">
                  <span>Purchase Orders</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2">
            <div class="list-content stock arrow arrow-right arrow-down-small">
              
              <div class="link">
                <a href="{{ route('admin.stocks.redirect') }}" class="text-yellow">
                  <img src="{{ asset('images/dashboard/ic_stock.png') }}" alt="Stock">
                  <span class="text-yellow">Stock</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xsmall-2">
            <div class="list-wrap">
              <div class="list-content arrow arrow-top-left-bi">
                <div class="link">
                  <a href="/memos">
                    <img src="{{ asset('images/dashboard/ic_active.png') }}" alt="Active Memos">
                    <span>Active Memos</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2"></div>
          <div class="col-xsmall-2">
            <div class="list-content action arrow arrow-up-right">
              <div class="list-content quotes arrow arrow-right-medium" style="margin-top: 20px;"></div>
              <div class="link">
                <a href="/action-required">
                  <img src="{{ asset('images/dashboard/ic_actions.png') }}" alt="Action Required">
                  <span>Action Required</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-2"></div>
          <div class="col-xsmall-2"> 
            <div class="list-content supplier arrow arrow-right-small" style="padding-top: 15px;">     
              <div class="link stock-jone">
                <a href="/stock-allocations">
                  <img src="{{ asset('images/dashboard/ic_stock-jones.png') }}" alt="Stock Allocations">
                  <span>Stock Allocations</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xsmall-1">
            <div class="link text-green" data-text="DISPATCH">
                <div class="link">
                <a href="{{ route('admin.installation-complaints.index') }}">
                  <img src="{{ asset('images/dashboard/ic_installation-complaints.png') }}" alt="Supplier">
                  <span>Supplier Complaints</span>
                </a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
