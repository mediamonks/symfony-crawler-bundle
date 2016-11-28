Step 3: Using the bundle
========================

Basic Usage
-----------

Extend ``\MediaMonks\CrawlerBundle\Command\CrawlUrlCommand`` and override the ``handlePage`` function.

.. code-block:: php

    <?php

    namespace AppBundle\Command;

    use MediaMonks\CrawlerBundle\Command\CrawlUrlCommand as BaseCrawlUrlCommand;
    use MediaMonks\Crawler\Page;

    class CrawlUrlCommand extends BaseCrawlUrlCommand
    {
        /**
         * @param Page $page
         */
        protected function handlePage(Page $page)
        {
            // do something with $page
        }
    }

.. note::
