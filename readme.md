# SD2
SiteDraw Library v2.0

## Developing

Use BrowserSync to simplify dev process

    browser-sync start --files "sd2/sd/**/*.*,projects/bcreator/m/**/*.*" --proxy "project.dev"

### Debug styling dialogs

#### Font

    setTimeout(function () {
      new Ngn.sd.FontSelectDialog({
        value: 'Pixar_One_Regular'
      });
    }, 500);
    
#### Document settings

    setTimeout(function() {
      new Ngn.Dialog.RequestForm({
        url: '/cpanel/{bannerId}/json_settings',
        width: 250,
        top: 100,
        onSubmitSuccess: function(r) {
          Ngn.sd.setBannerSize(r);
        }
      });
    }, 500);

#### Block settings

    setTimeout(function() {
      Ngn.sd.blocks[{blockId}]._settingsAction();
    }, 500);
    