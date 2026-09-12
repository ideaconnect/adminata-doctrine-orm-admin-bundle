.. index::
    double: Reference; Templates

Templates
=========

You can customize the global layout by tweaking the ``AdminataBundle`` configuration:

.. code-block:: yaml

    # config/packages/adminata.yaml

    adminata:
        templates:
            # default global templates
            layout:  '@Adminata/standard_layout.html.twig'
            ajax:    '@Adminata/ajax_layout.html.twig'

            # default value if done set, actions templates, should extend global templates
            list:    '@Adminata/CRUD/list.html.twig'
            show:    '@Adminata/CRUD/show.html.twig'
            edit:    '@Adminata/CRUD/edit.html.twig'

You can also customize field types by adding types in your configuration file.
The default values are:

.. code-block:: yaml

    # config/packages/adminata_doctrine_orm.yaml

    adminata_doctrine_orm:
        templates:
            types:
                list:
                    array:      '@Adminata/CRUD/list_array.html.twig'
                    boolean:    '@Adminata/CRUD/list_boolean.html.twig'
                    date:       '@Adminata/CRUD/list_date.html.twig'
                    time:       '@Adminata/CRUD/list_time.html.twig'
                    datetime:   '@Adminata/CRUD/list_datetime.html.twig'
                    text:       '@Adminata/CRUD/base_list_field.html.twig'
                    trans:      '@Adminata/CRUD/list_trans.html.twig'
                    string:     '@Adminata/CRUD/base_list_field.html.twig'
                    smallint:   '@Adminata/CRUD/base_list_field.html.twig'
                    bigint:     '@Adminata/CRUD/base_list_field.html.twig'
                    integer:    '@Adminata/CRUD/base_list_field.html.twig'
                    decimal:    '@Adminata/CRUD/base_list_field.html.twig'
                    identifier: '@Adminata/CRUD/base_list_field.html.twig'

                show:
                    array:      '@Adminata/CRUD/show_array.html.twig'
                    boolean:    '@Adminata/CRUD/show_boolean.html.twig'
                    date:       '@Adminata/CRUD/show_date.html.twig'
                    time:       '@Adminata/CRUD/show_time.html.twig'
                    datetime:   '@Adminata/CRUD/show_datetime.html.twig'
                    text:       '@Adminata/CRUD/base_show_field.html.twig'
                    trans:      '@Adminata/CRUD/show_trans.html.twig'
                    string:     '@Adminata/CRUD/base_show_field.html.twig'
                    smallint:   '@Adminata/CRUD/base_show_field.html.twig'
                    bigint:     '@Adminata/CRUD/base_show_field.html.twig'
                    integer:    '@Adminata/CRUD/base_show_field.html.twig'
                    decimal:    '@Adminata/CRUD/base_show_field.html.twig'

.. note::

    By default, if the ``SonataIntlBundle`` classes are available, then the numeric and date fields will be localized with the current user locale.
