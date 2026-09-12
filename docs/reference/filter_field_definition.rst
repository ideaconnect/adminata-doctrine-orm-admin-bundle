.. index::
    double: Reference; Templates
    single: Filter type
    single: Filter field

Filter field definition
=======================

These fields are displayed inside the filter box. They allow you to filter the list of entities by a number of different methods.

A filter instance is always linked to a Form Type, there are 7 types available:

* `IDCT\Adminata\Form\Type\Filter\NumberType`: display 2 widgets, the operator ( >, >=, <=, <, =) and the value,
* `IDCT\Adminata\Form\Type\Filter\ChoiceType`: display 2 widgets, the operator (yes and no) and the value,
* `IDCT\Adminata\Form\Type\Filter\DefaultType`: display 2 widgets, an hidden operator (can be changed on demand) and the value,
* `IDCT\Adminata\Form\Type\Filter\DateType`: display 2 widgets, the operator ( >, >=, <= , <, =) and the value,
* `IDCT\Adminata\Form\Type\Filter\DateRangeType`: display 3 widgets, the operator (between and not between) and the two values,
* `IDCT\Adminata\Form\Type\Filter\DateTimeType`: display 2 widgets, the operator ( >, >=, <= , <, =) and the value,
* `IDCT\Adminata\Form\Type\Filter\DateTimeRangeType`: display 3 widgets, the operator (between and not between) and the two values,

The `Form Type` configuration is provided by the filter itself.
But they can be tweaked in the ``configureDatagridFilters`` process with the ``add`` method.

The ``add`` method accepts 4 arguments:

* the `field name`, fields of relations (of relations of relations … ) can be
  specified with a dot-separated syntax,
* the `filter type`, the filter name,
* the `filter options`, the options related to the filter,
* the `field description options`, the options related to the field.

Available filter types
----------------------

For now, only `Doctrine ORM` filters are available:

* ``IDCT\Adminata\DoctrineORM\Filter\BooleanFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DefaultType`` Form Type, renders yes or no field,
* ``IDCT\Adminata\DoctrineORM\Filter\CallbackFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DefaultType`` Form Type, types can be configured as needed,
* ``IDCT\Adminata\DoctrineORM\Filter\ChoiceFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\ChoiceType`` Form Type,
* ``IDCT\Adminata\DoctrineORM\Filter\CountFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\NumberType`` Form Type,
* ``IDCT\Adminata\DoctrineORM\Filter\NumberFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\NumberType`` Form Type,
* ``IDCT\Adminata\DoctrineORM\Filter\ModelAutocompleteFilter``: uses ``IDCT\Adminata\Form\Type\Filter\ModelAutocompleteType`` form type, can be used as replacement of ``IDCT\Adminata\DoctrineORM\Filter\ModelFilter`` to handle too many items that cannot be loaded into memory.
* ``IDCT\Adminata\DoctrineORM\Filter\StringFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\ChoiceType`` Form Type,
* ``IDCT\Adminata\DoctrineORM\Filter\StringListFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\ChoiceType`` Form Type,
* ``IDCT\Adminata\DoctrineORM\Filter\DateFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DateType`` Form Type, renders a date field,
* ``IDCT\Adminata\DoctrineORM\Filter\DateRangeFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DateRangeType`` Form Type, renders a 2 date fields,
* ``IDCT\Adminata\DoctrineORM\Filter\DateTimeFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DateTimeType`` Form Type, renders a datetime field,
* ``IDCT\Adminata\DoctrineORM\Filter\DateTimeRangeFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DateTimeRangeType`` Form Type, renders a 2 datetime fields,
* ``IDCT\Adminata\DoctrineORM\Filter\ClassFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DefaultType`` Form type, renders a choice list field.
* ``IDCT\Adminata\DoctrineORM\Filter\NullFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DefaultType`` Form type, renders a choice list field.
* ``IDCT\Adminata\DoctrineORM\Filter\EmptyFilter``: depends on the ``IDCT\Adminata\Form\Type\Filter\DefaultType`` Form type, renders a choice list field.

Example
-------

.. code-block:: php

    namespace Sonata\NewsBundle\Admin;

    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $filter): void
        {
            $filter
                ->add('title')
                ->add('enabled')
                ->add('tags', null, [
                    'field_options' => ['expanded' => true, 'multiple' => true],
                ]);
        }
    }

BooleanFilter
-------------

The boolean filter has additional options:

* ``treat_null_as`` - set to ``false``, ``null`` values in database will be considered as falsy. Set to ``true``,
  ``null`` values in database will be considered as truthy. By default ``null`` is used.

StringFilter
------------

The string filter has additional options:

* ``force_case_insensitivity`` - set to ``true`` to make the search case insensitive. By default ``false`` is used,
  letting the database to apply its default behavior.
* ``trim`` - use one of ``IDCT\Adminata\DoctrineORM\Filter\TRIM_*`` constants to control the clearing of blank spaces around in the value. By default ``IDCT\Adminata\DoctrineORM\Filter\TRIM_BOTH`` is used.
* ``allow_empty`` - set to ``true`` to enable search by empty value. By default ``false`` is used.
* ``global_search`` - set to ``true`` to enable the use of this filter in the global search. By default ``true`` is used.

StringListFilter
----------------

This filter is made for filtering on values saved in databases as serialized arrays of strings with the
``#[ORM\Column(type: Types::ARRAY)]`` attribute. It is recommended to use another table and ``OneToMany`` relations
if you want to make complex ``SQL`` queries or if your table is too big and you get performance issues but
this filter can provide some basic queries::

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('labels', StringListFilter::class, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => [
                        'patch' => 'patch',
                        'minor' => 'minor',
                        'major' => 'major',
                        'approved' => 'approved',
                        // ...
                    ],
                    'multiple' => true,
                ],
            ]);
    }

.. note::

    The filter can give bad results with associative arrays since it is not easy to distinguish between keys
    and values for a serialized associative array.

JsonListFilter and custom filters
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The ``StringListFilter`` above will only work for columns of type ``array``.
In order to make a filter which will work with a column of type ``JSON`` you can **create your own filter**.

First you need to install the **Doctrine JSON functions** and enable them:

.. code-block:: bash

    composer require "scienta/doctrine-json-functions"

``config/packages/doctrine.yaml``:

.. code-block:: yaml

    doctrine:
        orm:
            dql:
                string_functions:
                    JSON_CONTAINS: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonContains
                    JSON_ARRAY: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonArray
                    JSON_LENGTH: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonLength

The new filter can be created from the basic ``Filter`` class::

    declare(strict_types=1);

    namespace App\Filter;

    use IDCT\Adminata\Filter\Model\FilterData;
    use IDCT\Adminata\Form\Type\Filter\ChoiceType;
    use IDCT\Adminata\Form\Type\Operator\ContainsOperatorType;
    use IDCT\Adminata\DoctrineORM\Datagrid\ProxyQueryInterface;
    use IDCT\Adminata\DoctrineORM\Filter\Filter;

    final class JsonListFilter extends Filter
    {
        public function filter(ProxyQueryInterface $query, string $alias, string $field, FilterData $data): void
        {
            if (!$data->hasValue()) {
                return;
            }

            $value = $data->getValue();

            if (!\is_array($value)) {
                $data = $data->changeValue([$value]);
            }

            $operator = $data->isType(ContainsOperatorType::TYPE_NOT_CONTAINS) ? 'NOT ' : '';

            $andConditions = $query->getQueryBuilder()->expr()->andX();

            $parameterName = $this->getNewParameterName($query);
            $andConditions->add(sprintf('%sJSON_CONTAINS(%s.%s, JSON_ARRAY(:%s)) = 1', $operator, $alias, $field, $parameterName));

            $query->getQueryBuilder()->setParameter($parameterName, $value);

            if ($data->isType(ContainsOperatorType::TYPE_EQUAL)) {
                $parameterName = $this->getNewParameterName($query);
                $andConditions->add(sprintf('JSON_LENGTH(%s.%s) = :%s', $alias, $field, $parameterName));

                $query->getQueryBuilder()->setParameter($parameterName, \count($data->getValue()));
            }

            $this->applyWhere($query, $andConditions);
        }

        public function getDefaultOptions(): array
        {
            return [];
        }

        public function getRenderSettings(): array
        {
            return [ChoiceType::class, [
                'field_type' => $this->getFieldType(),
                'field_options' => $this->getFieldOptions(),
                'label' => $this->getLabel(),
            ]];
        }
    }

Lastly you need to enable the newly created filter:

.. code-block:: yaml

    App\Filter\JsonListFilter:
        tags:
            - { name: adminata.admin.filter.type }

ModelAutocompleteFilter
-----------------------

This filter type uses ``IDCT\Adminata\Form\Type\ModelAutocompleteType`` form type. It renders an input with select2 autocomplete feature.
Can be used as replacement of ``IDCT\Adminata\DoctrineORM\Filter\ModelFilter`` to handle too many related items that cannot be loaded into memory.
This form type requires ``property`` option. See documentation of ``IDCT\Adminata\Form\Type\ModelAutocompleteType`` for all available options for this form type::

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('category', ModelAutocompleteFilter::class, [
                // in related CategoryAdmin there must be datagrid filter on `title` field to make the autocompletion work
                'field_options' => ['property'=>'title'],
            ]);
    }

DateRangeFilter
---------------

The ``IDCT\Adminata\DoctrineORM\Filter\DateRangeFilter`` filter renders two fields to filter all records between two dates.
If only one date is set it will filter for all records until or since the given date::

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('created', DateRangeFilter::class);
    }

Timestamps
----------

``IDCT\Adminata\DoctrineORM\Filter\DateFilter``, ``IDCT\Adminata\DoctrineORM\Filter\DateRangeFilter``, ``IDCT\Adminata\DoctrineORM\Filter\DateTimeFilter`` and ``IDCT\Adminata\DoctrineORM\Filter\DateTimeRangeFilter``
support filtering of timestamp fields by specifying ``'input_type' => 'timestamp'`` option::

    namespace Sonata\NewsBundle\Admin;

    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;
    use IDCT\Adminata\DoctrineORM\Filter\DateTimeRangeFilter;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $filter): void
        {
            $filter
                ->add('timestamp', DateTimeRangeFilter::class, ['input_type' => 'timestamp']);
        }
    }

ClassFilter
-----------

``IDCT\Adminata\DoctrineORM\Filter\ClassFilter`` supports filtering on hierarchical entities. You need to specify the ``sub_classes`` option::

    namespace Sonata\NewsBundle\Admin;

    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;
    use IDCT\Adminata\DoctrineORM\Filter\ClassFilter;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $filter): void
        {
            $filter
                ->add('type', ClassFilter::class, ['sub_classes' => $this->getSubClasses()]);
        }
    }

NullFilter
----------

``IDCT\Adminata\DoctrineORM\Filter\NullFilter`` supports filtering for null entity fields::

    namespace Sonata\NewsBundle\Admin;

    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;
    use IDCT\Adminata\Filter\NullFilter;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $filter): void
        {
            $filter
                ->add('deleted', NullFilter::class, ['field_name' => 'deletedAt']);
        }
    }

The ``inverse`` option can be used to filter values that are not null.

EmptyFilter
-----------

``IDCT\Adminata\DoctrineORM\Filter\EmptyFilter`` supports filtering for empty OneToMany relations::

    namespace Sonata\NewsBundle\Admin;

    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;
    use IDCT\Adminata\Filter\NullFilter;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $datagridMapper)
        {
            $datagridMapper
                ->add('tags', EmptyFilter::class);
        }
    }

The ``inverse`` option can be used to filter values that are not empty.

ChoiceFilter
------------

``IDCT\Adminata\DoctrineORM\Filter\ChoiceFilter`` supports filtering for custom values::

    // src/Admin/BlogPostAdmin.php

    namespace App\Admin;

    use IDCT\Adminata\Datagrid\DatagridMapper;
    use IDCT\Adminata\DoctrineORM\Filter\ChoiceFilter;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

    final class BlogPostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $datagrid): void
        {
            $datagrid
                ->add('title')
                ->add('state', ChoiceFilter::class, [
                    'label' => 'State',
                    'field_type' => ChoiceType::class,
                    'field_options' => [
                        'choices' => [
                            'new' => 'new',
                            'open' => 'open',
                            'closed' => 'closed',
                        ],
                    ],
                ])
            ;
        }
    }

Advanced usage
--------------

Filtering by sub entity properties
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you need to filter your base entities by the value of a sub entity property, you can simply use the dot-separated notation::

    namespace App\Admin;

    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;

    final class UserAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $filter): void
        {
            $filter
                ->add('id')
                ->add('firstName')
                ->add('lastName')
                ->add('address.street')
                ->add('address.ZIPCode')
                ->add('address.town');
        }
    }

.. note::

    This only makes sense when the prefix path is made of entities, not collections.

Label
^^^^^

You can customize the label which appears on the main widget by using a ``label`` option::

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('tags', null, [
                'label' => 'les tags'
                'field_options' => ['expanded' => true, 'multiple' => true],
            ]);
    }

Callback
^^^^^^^^

To create a custom callback filter, a method to define how to use the field's value needs to be implemented.
It shall return whether the filter actually is applied to the query builder or not.

In this example, this functionality is provided by an anonymous function, but this option accepts any
callable syntax::

    namespace Sonata\NewsBundle\Admin;

    use Application\Sonata\NewsBundle\Entity\Comment;
    use IDCT\Adminata\Admin\AbstractAdmin;
    use IDCT\Adminata\Datagrid\DatagridMapper;
    use IDCT\Adminata\Filter\Model\FilterData;
    use IDCT\Adminata\DoctrineORM\Datagrid\ProxyQueryInterface;
    use IDCT\Adminata\DoctrineORM\Filter\CallbackFilter;
    use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

    final class PostAdmin extends AbstractAdmin
    {
        protected function configureDatagridFilters(DatagridMapper $filter): void
        {
            $filter
                ->add('title')
                ->add('enabled')
                ->add('tags', null, [
                    'field_options' => ['expanded' => true, 'multiple' => true],
                ])
                ->add('author')
                ->add('with_open_comments', CallbackFilter::class, [
                    // This option accepts any callable syntax.
                    // 'callback' => [$this, 'getWithOpenCommentFilter'],
                    'callback' => static function(ProxyQueryInterface $query, string $alias, string $field, FilterData $data): bool {
                        if (!$data->hasValue()) {
                            return false;
                        }

                        $query
                            ->leftJoin(sprintf('%s.comments', $alias), 'c')
                            ->andWhere('c.status = :status')
                            ->setParameter('status', Comment::STATUS_MODERATE);

                        return true;
                    },
                    'field_type' => CheckboxType::class,
                ]);
        }
    }
