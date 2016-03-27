if (!Ngn.sd.blockTypes) Ngn.sd.blockTypes = [];

Ngn.sd.blockTypes.push({
  title: 'Font',
  data: {
    type: 'font'
  },
  editDialogOptions: {
    width: 300,
    dialogClass: 'dialog elNoPadding',
    vResize: Ngn.Dialog.VResize.Textarea
  }
});
