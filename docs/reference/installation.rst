.. index::
    double: Reference; Installation

Installation
============

``AdminataDoctrineORMBundle`` is part of a set of bundles aimed at abstracting storage connectivity for ``AdminataBundle``.
As such, ``AdminataDoctrineORMBundle`` depends on ``AdminataBundle`` and will not work without it.

.. note::

    These installation instructions are meant to be used only as part of AdminataBundle's installation process,
    which is documented `here <https://github.com/ideaconnect/adminata/blob/main/docs/admin-bundle/getting_started/installation.rst>`_.

Download the bundle
-------------------

This bundle is not on Packagist yet, so name the repository it installs from first:

.. code-block:: json

    "repositories": [
        { "type": "vcs", "url": "https://github.com/ideaconnect/adminata-doctrine-orm-admin-bundle.git" }
    ]

.. code-block:: bash

    composer require idct/adminata-doctrine-orm-admin-bundle

Enable the bundle
-----------------

Next, be sure to enable the bundles in your ``bundles.php`` file if they
are not already enabled::

    // config/bundles.php

    return [
        // ...
        IDCT\Adminata\DoctrineORM\AdminataDoctrineORMBundle::class => ['all' => true],
    ];

.. note::

    Don't forget that, as part of `AdminataBundle's installation instructions <https://github.com/ideaconnect/adminata/blob/main/docs/admin-bundle/getting_started/installation.rst>`_,
    you need to enable additional bundles on `bundles.php`.
