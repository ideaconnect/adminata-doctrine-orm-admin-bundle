.. index::
    double: Reference; Configuration
    single: Options

Configuration
=============

The configuration section is only about the ``AdminataDoctrineORMBundle``.
For more information about the global configuration of the ``AdminataBundle``, please refer to the dedicated documentation.

Full configuration options
==========================

.. code-block:: yaml

    adminata_doctrine_orm:
        # default value is null, so doctrine uses the value defined in the configuration
        entity_manager: ~

        audit:
            force: true

        templates:
            types:
                list:
                    array:      "@Adminata/CRUD/list_array.html.twig"
                    boolean:    "@Adminata/CRUD/list_boolean.html.twig"
                    date:       "@Adminata/CRUD/list_date.html.twig"
                    time:       "@Adminata/CRUD/list_time.html.twig"
                    datetime:   "@Adminata/CRUD/list_datetime.html.twig"
                    text:       "@Adminata/CRUD/base_list_field.html.twig"
                    trans:      "@Adminata/CRUD/list_trans.html.twig"
                    string:     "@Adminata/CRUD/base_list_field.html.twig"
                    smallint:   "@Adminata/CRUD/base_list_field.html.twig"
                    bigint:     "@Adminata/CRUD/base_list_field.html.twig"
                    integer:    "@Adminata/CRUD/base_list_field.html.twig"
                    decimal:    "@Adminata/CRUD/base_list_field.html.twig"
                    identifier: "@Adminata/CRUD/base_list_field.html.twig"
                    currency:   "@Adminata/CRUD/list_currency.html.twig"
                    percent:    "@Adminata/CRUD/list_percent.html.twig"
                    choice:     "@Adminata/CRUD/list_choice.html.twig"
                    url:        "@Adminata/CRUD/list_url.html.twig"

                show:
                    array:      "@Adminata/CRUD/show_array.html.twig"
                    boolean:    "@Adminata/CRUD/show_boolean.html.twig"
                    date:       "@Adminata/CRUD/show_date.html.twig"
                    time:       "@Adminata/CRUD/show_time.html.twig"
                    datetime:   "@Adminata/CRUD/show_datetime.html.twig"
                    text:       "@Adminata/CRUD/base_show_field.html.twig"
                    trans:      "@Adminata/CRUD/show_trans.html.twig"
                    string:     "@Adminata/CRUD/base_show_field.html.twig"
                    smallint:   "@Adminata/CRUD/base_show_field.html.twig"
                    bigint:     "@Adminata/CRUD/base_show_field.html.twig"
                    integer:    "@Adminata/CRUD/base_show_field.html.twig"
                    decimal:    "@Adminata/CRUD/base_show_field.html.twig"
                    currency:   "@Adminata/CRUD/base_currency.html.twig"
                    percent:    "@Adminata/CRUD/base_percent.html.twig"
                    choice:     "@Adminata/CRUD/show_choice.html.twig"
                    url:        "@Adminata/CRUD/show_url.html.twig"
