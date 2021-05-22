<?php

namespace App\Constants;

/**
 * Class DBTable.
 * @package App\Constants
 */
class DBTable
{
    /***************************************
     * System specific models.
     ***************************************/
    const MIGRATIONS      = 'sys_migrations';
    const LOGS_ACTIVITIES = 'sys_activity_logs';

    /***************************************
     * Auth specific models.
     ***************************************/
    const AUTH_USERS             = 'auth_users';
    const AUTH_PASSWORD_RESETS   = 'auth_password_resets';
    const AUTH_ROLES             = 'auth_roles';
    const AUTH_USERS_ROLES       = 'auth_users_roles';
    const AUTH_PERMISSIONS       = 'auth_permissions';
    const AUTH_USERS_PERMISSIONS = 'auth_users_permissions';
    const AUTH_ROLES_PERMISSIONS = 'auth_roles_permissions';

    /***************************************
     * Module specific models.
     ***************************************/
    const CUSTOMERS                  = 'tbl_customers';
    const JOB_SOURCES                = 'tbl_job_sources';
    const CUSTOMER_SITES             = 'tbl_customer_sites';
    const CUSTOMER_SETTINGS          = 'tbl_customer_settings';
    const PIVOT_CUSTOMER_SALES       = 'pivot_customer_sales';
    const PIVOT_CUSTOMER_JOB_SOURCE  = 'pivot_customer_job_source';
    const SUPPLIERS                  = 'tbl_suppliers';
    const SUPPLIER_SITES             = 'tbl_supplier_sites';
    const PIVOT_JOB_SOURCE_SUPPLIER  = 'pivot_job_source_supplier';
    const PIVOT_SALES_STAFF_SUPPLIER = 'pivot_sales_staff_supplier';
    const PRODUCT_CATEGORIES         = 'tbl_product_categories';
    const MATERIAL_PRODUCTS          = 'tbl_material_products';
    const LABOUR_PRODUCTS            = 'tbl_labour_products';
    const PRODUCTS                   = 'tbl_products';
    const PRODUCT_VARIANTS           = 'tbl_product_variants';
    const TEMPLATES                  = 'tbl_templates';
    const STOCKS                     = 'tbl_stocks';
    /*
   |--------------------------------------------------------------------------
   | Job specific tables.
   |--------------------------------------------------------------------------
   */
    const QUOTES                            = 'tbl_quotes';
    const PIVOT_QUOTES_SALES                = 'pivot_quotes_sales';
    const PIVOT_QUOTES_MATERIAL_SALES_PRICE = 'pivot_quotes_material_sales_price';
    const PIVOT_QUOTES_LABOUR_SALES_PRICE   = 'pivot_quotes_labour_sales_price';
    const MEMOS                             = 'tbl_memos';
    const JOB_INVOICES                      = 'tbl_job_invoices';
    const INVOICE_RECEIPT                   = 'tbl_invoice_receipts';
    const JOB_RECEIPT                       = 'tbl_job_receipts';
    const QUOTE_MEMOS                       = 'tbl_quote_memos';
    /*
    |--------------------------------------------------------------------------
    | Job specific tables.
    |--------------------------------------------------------------------------
    */
    const JOBS                            = 'tbl_jobs';
    const PIVOT_JOBS_SALES                = 'pivot_jobs_sales';
    const PIVOT_JOBS_MATERIAL_SALES_PRICE = 'pivot_jobs_material_sales_price';
    const PIVOT_JOBS_LABOUR_SALES_PRICE   = 'pivot_jobs_labour_sales_price';
    const TERMS_AND_CONDITIONS            = 'tbl_terms_and_conditions';
    /*
    |--------------------------------------------------------------------------
    | Booking specific tables.
    |--------------------------------------------------------------------------
    */
    const BOOKINGS          = 'tbl_bookings';
    const BOOKING_TYPES     = 'tbl_booking_types';
    /*
    |--------------------------------------------------------------------------
    | Installation Complaint specific tables.
    |--------------------------------------------------------------------------
    */
    const INSTALLATION_COMPLAINTS = 'tbl_installation_complaints';

    /*
    |--------------------------------------------------------------------------
    | Stock specific tables.
    |--------------------------------------------------------------------------
    */
    const CURRENT_STOCK = 'tbl_current_stocks';
    const FUTURE_STOCK = 'tbl_future_stocks';
    const FUTURE_STOCK_RECEIVE_GROUP = 'tbl_future_stock_receive_group';
    
    const CURRENT_ORDER = 'tbl_current_orders';
    const ORDER_RECEIPT = 'tbl_order_receipts';
    const DELIVERY_ORDERS = 'tbl_delivery_orders';

    /*
    |--------------------------------------------------------------------------
    | General Setting specific tables.
    |--------------------------------------------------------------------------
    */
    const GENERAL_SETTING = 'tbl_general_settings';

    /*
    |--------------------------------------------------------------------------
    | Account specific tables.
    |--------------------------------------------------------------------------
    */
    const ACCOUNT = 'tbl_accounts';
    const TRANSACTION_JOURNAL = 'transaction_journals';
    const CASH_BOOK = 'cash_books';

   /*
   |--------------------------------------------------------------------------
   | Contractor specific tables.
   |--------------------------------------------------------------------------
   */
   const CONTRACTOR = 'tbl_contractors';
   const CONTRACTOR_PAYMENT_DUE = 'tbl_contractor_payments_due';

   const SHOPS = 'shops';

   const SITES = 'sites';

   const USER_SITES = 'user_sites';

   const SALES_STAFF = 'sales_staff';

   const STATES = 'states';

   const REMITTANCE = 'remittances';

   const REMITTANCE_ITEMS = 'remittance_items';

   const STOCK_MARRY_INVOICES = 'stock_marry_invoices';

   const STOCK_ALLOCATIONS = 'allocations';
   
   const STOCK_BACK_ORDERS = 'back_orders';

   const SITE_AUTOMATED_MEMOS = 'site_automated_memos';

   const ALLOCATION_DISPATCH = 'allocation_dispatches';

   const SUPPLIER_PAYABLE = 'supplier_payables';
}
