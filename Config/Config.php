<?php

namespace MySqlSync\Config;

/**
 * Config
 */
class Config
{
    const LEFT_DATABASE = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'password1',
        'database' => 'm1_backup_new',
    ];

    const RIGHT_DATABASE = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'password1',
        'database' => 'm1_backup_0403',
    ];

    const TABLE_NAMES = [
        'customer_entity' => 'entity_id',
        'customer_entity_datetime' => 'value_id',
        'customer_entity_decimal' => 'value_id',
        'customer_entity_int' => 'value_id',
        'customer_entity_text' => 'value_id',
        'customer_entity_varchar' => 'value_id',
        'customer_address_entity' => 'entity_id',
        'customer_address_entity_datetime' => 'value_id',
        'customer_address_entity_decimal' => 'value_id',
        'customer_address_entity_int' => 'value_id',
        'customer_address_entity_text' => 'value_id',
        'customer_address_entity_varchar' => 'value_id',
        'sales_flat_quote' => 'entity_id',
        'sales_flat_order' => 'entity_id',
        'sales_flat_creditmemo' => 'entity_id',
        'sales_flat_creditmemo_grid' => 'entity_id',
        'sales_flat_creditmemo_item' => 'entity_id',
        'sales_flat_invoice' => 'entity_id',
        'sales_flat_invoice_grid' => 'entity_id',
        'sales_flat_invoice_item' => 'entity_id',
        'sales_flat_order_address' => 'entity_id',
        'sales_flat_order_grid' => 'entity_id',
        'sales_flat_order_item' => 'item_id',
        'sales_flat_order_payment' => 'entity_id',
        'sales_flat_order_status_history' => 'entity_id',
        'sales_flat_quote_address' => 'address_id',
        'sales_flat_quote_address_item' => 'address_item_id',
        'sales_flat_quote_item' => 'item_id',
        'sales_flat_quote_item_option' => 'option_id',
        'sales_flat_quote_payment' => 'payment_id',
        'sales_flat_quote_shipping_rate' => 'rate_id',
        'sales_flat_shipment' => 'entity_id',
        'sales_flat_shipment_comment' => 'entity_id',
        'sales_flat_shipment_grid' => 'entity_id',
        'sales_flat_shipment_item' => 'entity_id',
        'sales_flat_shipment_track' => 'entity_id',
        'sales_order_tax' => 'tax_id',
        'sales_order_tax_item' => 'tax_item_id',
        'sales_payment_transaction' => 'transaction_id',
        'downloadable_link_purchased' => 'purchased_id',
        'downloadable_link_purchased_item' => 'item_id',
        'eav_entity_store' => 'entity_store_id',
        'gift_message' => 'gift_message_id',
        'log_visitor' => 'visitor_id',
        'newsletter_subscriber' => 'subscriber_id',
        'rating_option_vote' => 'vote_id',
        'rating_option_vote_aggregated' => 'primary_id',
        'report_compared_product_index' => 'index_id',
        'report_event' => 'event_id',
        'report_viewed_product_index' => 'index_id',
        'review' => 'review_id',
        'review_detail' => 'detail_id',
        'review_entity_summary' => 'primary_id',
        // TODO: 'review_store' => '',
        'wishlist' => 'wishlist_id',
        'wishlist_item' => 'wishlist_item_id',
        'wishlist_item_option' => 'option_id',
        'catalog_compare_item' => 'catalog_compare_item_id',
        'cataloginventory_stock_item' => 'item_id',
    ];

    const DRY_RUN = TRUE;
}
