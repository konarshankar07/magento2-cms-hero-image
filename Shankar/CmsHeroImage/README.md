# Shankar_CmsHeroImage module

The Shankar_CmsHeroImage module introduce the feature for Admin user can add the hero image for each CMS page 

## Dependencies

`Shankar_CmsHeroImage` depends on following modules:
- `Magento_Cms`

## Extensibility

Extension developers can interact with the Shankar_CmsHeroImage module. For more information about the Magento extension mechanism, see [Magento plug-ins](https://devdocs.magento.com/guides/v2.3/extension-dev-guide/plugins.html).

[The Magento dependency injection mechanism](https://devdocs.magento.com/guides/v2.3/extension-dev-guide/depend-inj.html) enables you to override the functionality of the Shankar_CmsHeroImage module.

### UI components

`cms_page_form.xml` UI components is extended and located in the `view/adminhtml/ui_component` directory.

For information about a UI component in Magento 2, see [Overview of UI components](https://devdocs.magento.com/guides/v2.3/ui_comp_guide/bk-ui_comps.html).

### Plugins

`Plugin` is created for the Data Provider for setting the hero image in UI component

### Events

`cms_page_prepare_save` event is used to reformat the data for the hero image before saving to the database 


