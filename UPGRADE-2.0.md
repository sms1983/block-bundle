# Upgrade from 1.x to 2.0

## Sonata Admin

 * The SonataAdminBundle integration has been moved to
   `symfony-cmf/sonata-admin-integration-bundle`. This includes the classes in
   the `Admin` namespace and related services; and the `use_sonata_admin`,
   `*_document_class` and `*_admin_class` settings.

   **Before**
   ```yaml
   # app/config/config.yml
   sonata_admin:
       extensions:
           cmf_block.admin_extension.cache:
               # ...
   ```

   **After**
   ```yaml
   # app/config/config.yml
   sonata_admin:
       extensions:
           cmf_sonata_admin_integration.block.extension.cache:
               # ...
   ```

   Admin service names also changed. If you are using the admin,
   you need to adjust your configuration, i.e. in the sonata dashboard:
   
   **Before**:
   
   ```yaml
        # app/config/config.yml
        sonata_admin:
            dashboard:
               groups:
                   content:
                       label: Content
                       icon: '<i class="fa fa-file-text-o"></i>'
                       items:
                           - cmf_block.simple_admin
                           - cmf_block.container_admin
                           - cmf_block.reference_admin
                           - cmf_block.action_admin
   ```

   **After**:
       
   ```yaml
        # app/config/config.yml
        sonata_admin:
           dashboard:
               groups:
                   content:
                       label: Content
                       icon: '<i class="fa fa-file-text-o"></i>'
                       items:
                           - cmf_sonata_admin_integration.block.simple_admin
                           - cmf_sonata_admin_integration.block.container_admin
                           - cmf_sonata_admin_integration.block.reference_admin
                           - cmf_sonata_admin_integration.block.action_admin
   ```