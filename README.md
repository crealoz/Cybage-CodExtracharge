## Cybage Custom COD Plugin
Overview
The module helps you to set COD charges for Payment method Cash On Deliver.

## Dependencies
You can find the list of modules that have dependencies on cod-extracharge module, in the require section of the composer.json file located in the same directory as this README.md file.

Extension Points
The cod-extracharge module does not provide any specific extension points. You can extend it using the Magento extension mechanism.

For more information about Magento extension mechanism, see Magento plug-ins and Magento dependency injection.

## Additional information
For more Magento 2 developer documentation, see Magento 2 Developer Documentation. Also, there you can track backward incompatible changes made in a Magento EE mainline after the Magento 2.0 release.

## Installing in your Magento

* From your CLI run: ```composer require cybage/cod-extracharge```
* Log-in your Magento backend
* Go to Stores > Configuration > Sales > Payment Methods > Cash On Delivery
* Configure Cash On Delivery according to your preferences



### Configuring fees

* Log-in your Magento backend
* Go to Stores > Configuration > Sales > Payment Methods > Cash On Delivery
* Scroll down untill you see **Export CSV** button
* Click and download **cyb_codextracharge.csv** file
* Change the CSV file and upload using the "browse" button
* Save


### CSV syntax

Cash On Delivery CSV file syntax is really simple. You have 5 columns:**website**, **country**,**amount_above** , **amount_max**, **cod_charge**, **is_pct**

* **country**: ISO 2 letters country code. Use * as wildcard to indicate all countries
* **website**: Magento website code (e.g.: *base*). Use * as wildcard to indicate all websites
* **amount_above**: Indicates the minimum amount to apply the additional fee
* **amount_msx**: Indicates the maximum amount to apply the additional fee
* **cod_charge**: The fee to apply (in base currency). Adding **%** after the fee indicates a percent value
* **is_pct**: 1 indicates caluclate Cod charge percentagewise.Default it's 0.
