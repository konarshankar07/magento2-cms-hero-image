# Magento 2 CMS Hero Image
Welcome to the CMS Hero Image project!

# Overview

CMS hero image provide to add hero image to individual CMS page. Magento user can add the image
using image uploader from the **Content -> Pages -> Add/Edit page**.

# How to contribute
1.Clone the magento2 git repository and check out the 2.4-develop branch. You may also check out and use any 2.4 release tags.

`git clone git@github.com:magento/magento2.git .`

2.Create an ext directory in the root of the magento2 project directory:

`cd magento2`

`mkdir ext`

3.Clone the cms-hero-image repository into the appropriate directory inside ext:

`git clone https://github.com/konarshankar07/magento2-cms-hero-image.git ext/shankar/cms-hero-image`

4.Minimum-stability for packages is updated to dev value. This allows installation of development modules:

  `composer config minimum-stability dev`
 
5.Next we configure Composer so that it knows where to find new modules. The following command will configure any extension code inside the ext directory to be treated as a package and symlinked to the vendor directory:

  `composer config repositories.ext path "./ext/*/*/*"`
  
6.Finally, install the cms-hero-image metapackage:

`composer require shankar/cms-hero-image`

7.Ensure CMS Hero Image modules are enabled bin/magento module:status / bin/magento module:enable (https://devdocs.magento.com/guides/v2.3/extension-dev-guide/build/enable-module.html).

8.Install/Upgrade the database

`bin/magento setup:install` ...
or
`bin/magento setup:upgrade`
At this point, all of the shankar/cms-hero-image modules are symlinked inside the vendor directory, which allows both running a Magento installation with additional modules as well as doing development using the standard git workflow.
