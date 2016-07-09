# Google Dynamic Remarketing Magento Extension

Plug and Play Magento Extension for add to site Google Dynamic Remarketing (type Custom) on any custom pages, all setting from admin panel.

[Features](#features)  
[Magento Compatibility](#magento-compatibility)   
[Setting](#settings)

## Features
- Simple in use
- Lightweight
- User friendly

## Magento Compatibility
The following version have passed all tests:
- CE 1.9.0.1

## Settings

**Properties**  
[Enable](#enable)                                                                                                                                                                                                                                    
**Additional properties**                                                                                                             
[Round](#round)                                                                                                                  
[Tax](#tax)                                                                                                                    

**Tracking pages**  
[home](#home)  
[searchresults](#searchresults)  
[offerdetail](#offerdetail)  
[conversionintent](#conversionintent)  
[conversion](#conversion)
[other](#other)

### Properties

_All setting in `System -> Configuration -> Sales -> Google API -> Google Display Network`_

#### Enable
Full Enable/Disable extension from admin panel.


### Additional properties

_All setting in `System -> Configuration -> Sales -> Google API -> Google Display Network`_

#### Round
Enable/Disable price round. Setup round precision, by default is 0.
`Disable by default`

#### Tax
Enable/Disable display price with tax.
`Disable by default`


### Tracking Pages
List of default setting for all standart pages from `Custom` remarketing - https://support.google.com/adwords/answer/3103357?hl=en


#### home

| Option              | Description                                             | Value                       |
| ------------------: | --------------------------------------------------------| --------------------------- |
| *Page type*         | Name of tracking pages, need for `dynx_pagetype` param  | `home`                      |
| *Full action name*  | Magento full action name                                | `cms_index_index`           |
| *Data extract type* | Magento page type, need for extract data                | `other`                     |

#### searchresults

| Option              | Description                                             | Value                       |
| ------------------: | --------------------------------------------------------| --------------------------- |
| *Page type*         | Name of tracking pages, need for `dynx_pagetype` param  | `searchresults`             |
| *Full action name*  | Magento full action name                                | `catalogsearch_result_index`|
| *Data extract type* | Magento page type, need for extract data                | `other`                     |

#### offerdetail

| Option              | Description                                             | Value                       |
| ------------------: | --------------------------------------------------------| --------------------------- |
| *Page type*         | Name of tracking pages, need for `dynx_pagetype` param  | `offerdetail`               |
| *Full action name*  | Magento full action name                                | `catalog_product_view`      |
| *Data extract type* | Magento page type, need for extract data                | `product page`              |

#### conversionintent

| Option              | Description                                             | Value                       |
| ------------------: | --------------------------------------------------------| --------------------------- |
| *Page type*         | Name of tracking pages, need for `dynx_pagetype` param  | `conversionintent`          |
| *Full action name*  | Magento full action name                                | `checkout_onepage_index`    |
| *Data extract type* | Magento page type, need for extract data                | `cart/checkout page`        |

#### conversion

| Option              | Description                                             | Value                       |
| ------------------: | --------------------------------------------------------| --------------------------- |
| *Page type*         | Name of tracking pages, need for `dynx_pagetype` param  | `conversion`                |
| *Full action name*  | Magento full action name                                | `checkout_onepage_success`  |
| *Data extract type* | Magento page type, need for extract data                | `success`                   |

#### other

| Option              | Description                                             | Value                       |
| ------------------: | --------------------------------------------------------| --------------------------- |
| *Page type*         | Name of tracking pages, need for `dynx_pagetype` param  | `other`                     |
| *Full action name*  | Magento full action name                                | ``                          |
| *Data extract type* | Magento page type, need for extract data                | `other`                     |
