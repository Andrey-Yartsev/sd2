if (!Ngn.sd.blockTypes) Ngn.sd.blockTypes = [];

alert('!');

Ngn.sd.blockTypes.push({
  title: 'Font',
  data: {
    type: 'cufon'
  },
  editDialogOptions: {
    width: 300,
    dialogClass: 'dialog elNoPadding',
    vResize: Ngn.Dialog.VResize.Textarea
  }
});
