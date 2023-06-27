// Call the dataTables jQuery plugin
$(document).ready(function () {
  var table = $('#dataTable').DataTable({
    searchPanes: true,
    "oLanguage": {
      "sSearch": "Filter:"
    },
  });
  table.searchPanes.container().prependTo(table.table().container());
  table.searchPanes.resizePanes();
});
