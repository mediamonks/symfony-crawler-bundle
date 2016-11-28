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

Using A Blacklist
-----------------

It might be that you want to skip certain pages from ending up in your index, for this you can use the blacklist feature.

In the example below all pages starting with /profile are not returned.

.. code-block:: yaml

    # app/config/services.yml
    crawler.url_matcher.blacklist.profile:
        class: MediaMonks\Crawler\Url\Matcher\PathRegexUrlMatcher
        arguments: ['~^/profile~']
        tags:
            - { name: mediamonks_crawler.blacklist_url_matcher }


You can have multiple blacklist url matchers and create custom matchers as long as it implements the ``MediaMonks\Crawler\Url\Matcher\UrlMatcherInterface``.

Using A Whitelist
-----------------

It can also be that you might be only interested in specific pages while ignoring everything else, then you can use the whitelist feature.

In the example below only pages starting with /news are returned.

.. code-block:: yaml

    # app/config/services.yml
    crawler.url_matcher.whitelist.news:
        class: MediaMonks\Crawler\Url\Matcher\PathRegexUrlMatcher
        arguments: ['~^/news~']
        tags:
            - { name: mediamonks_crawler.whitelist_url_matcher }

You can have multiple whitelist url matchers and create custom matchers as long as it implements the ``MediaMonks\Crawler\Url\Matcher\UrlMatcherInterface``.

Using normalizers
-----------------

You can run into multiple pages having the same content, to work around this you can add normalizers which can modify a url so it won't be returned multiple times.

In the example below where pages /foo and /foo?q=bar have the same result it will only be returned once as /foo.

.. code-block:: yaml

    # app/config/services.yml
    crawler.url_normalizer.remove_q:
        class: MediaMonks\Crawler\Url\Normalizer\RemoveQueryParameterUrlNormalizer
        arguments: ['q']
        tags:
            - { name: mediamonks_crawler.url_normalizer }
