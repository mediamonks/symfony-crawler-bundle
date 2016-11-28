Step 2: Configuring the bundle
==============================

Client
------

By default the bundle uses the Goutte client but you can set it to a different client if you like.
The package provides two additional clients: prerender & prerender_io which you can use in the bundle too.
You can also point to any other service that extends the Symfony Browserkit component.
When using prerender or prerender_io clients make sure that you configure them accordingly as  describer below.

.. code-block:: yaml

    # app/config/config.yml
    mediamonks_crawler:
        client: prerender

Limit
-----

It's possible to set a limit on the number of pages that will be crawled. By default there is no limit and the crawler will stop once all found pages are requested.

.. code-block:: yaml

    # app/config/config.yml
    mediamonks_crawler:
        limit: 100

Stop On Error
-------------

By default a page that could not be requested (regardless of reason) is skipped. It is possible to stop the crawler when this happens.

.. code-block:: yaml

    # app/config/config.yml
    mediamonks_crawler:
        stop_on_error: true/false

Exception On Error
------------------

By default a page that could not be requested (regardless of reason) is skipped. It is possible to throw an exception when this happens.

.. code-block:: yaml

    # app/config/config.yml
    mediamonks_crawler:
        exception_on_error: true/false

Prerender Client
----------------

.. code-block:: yaml

    # app/config/config.yml
    mediamonks_crawler:
        prerender:
            url: 'https://your-prerender-url/'

Prerender.io Client
-------------------

.. code-block:: yaml

    # app/config/config.yml
    mediamonks_crawler:
        prerender_io:
            token: 'your_prerender.io_token'
