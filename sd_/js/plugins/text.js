// @requires Ngn.Dialog.VResize.Wisiwig
if (!Ngn.Dialog.VResize.Wisiwig) throw new Error('Ngn.Dialog.VResize.Wisiwig not defined');
Ngn.sd.blockTypes.push({
  title: 'Текст',
  data: {
    type: 'text'
  },
  separateContent: true,
  editDialogOptions: {
    dialogClass: 'dialog elNoPadding',
    vResize: Ngn.Dialog.VResize.Wisiwig
  }
});
