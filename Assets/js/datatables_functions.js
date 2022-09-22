function ObjectsToDataTableArray(datas, columns) {
  var dataTableArray = [];

  datas.forEach((data) => {
    var row = [];
    for (let i = 0; i < columns.length; i++) {
      const column = columns[i];
      row.push(data[column]);
    }
    dataTableArray.push(row);
  });

  return dataTableArray;
}

function toDataTableColumn(columns, isWitheditButton, isWithdeleteButton) {
  var dataTableColumn = [];
  for (const columnKey in columns) {
    if (Object.hasOwnProperty.call(columns, columnKey)) {
      const columnName = columns[columnKey];
      dataTableColumn.push({
        title: columnName,
      });
    }
  }

  if (isWitheditButton) {
    var editButton = {
      data: null,
      className: "dt-center editor-edit",
      title: "Edit",
      defaultContent: `
            <button   type="button" class="btn btn-success edit-button" data-bs-toggle="modal" data-bs-target="#editModal">
                <i class="fa fa-pencil"></i>
            </button>
            `,
      orderable: false,
    };
    dataTableColumn.push(editButton);
  }
  var deleteVisibility = "visible";
  if (!isWithdeleteButton) {
    deleteVisibility = "invisible";
  }
  var deleteButton = {
    data: null,
    className: "dt-center editor-delete",
    defaultContent: `
        <button type="button" class="btn btn-secondary delete-button ${deleteVisibility}" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fa fa-trash"></i>
        </button>
        `,
    orderable: false,
  };
  dataTableColumn.push(deleteButton);

  return dataTableColumn;
}

function showDataTable(
  rows,
  columns,
  dataTableId,
  tableName,
  options = {
    isWitheditButton: true,
    isWithAddButton: true,
    isWithDropdownButton: true,
    isWithDropdownButton1: true,
    paging: true,
    isWithdeleteButton: true,
  }
) {
  columns = toDataTableColumn(
    columns,
    options.isWitheditButton,
    options.isWithdeleteButton
  );

  var DropdownButton = ``;
  if (tableName === "Online Links") {
    DropdownButton = `
    <select class="btn btn-primary">
        <option>Test1</option>
        <option>Test2</option>
    </button>
    `;
    if (!options.isWithDropdownButton) DropdownButton = "";
  }

  var DropdownButton1 = ``;
  if (tableName === "Onsite Links") {
    DropdownButton1 = `
    <select class="btn btn-primary">
        <option>Test1</option>
        <option>Test2</option>
    </button>
    `;
    if (!options.isWithDropdownButton1) DropdownButton1 = "";
  }

  var addButton = `
    <button type="button" id="addButtonForAllTable" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Add ${tableName}
    </button>
    `;
  if (!options.isWithAddButton) addButton = "";

  $(dataTableId).DataTable({
    data: rows,
    columns: columns,
    dom: "Bfrtip",
    buttons: ["colvis", "excel", "pdf", "print", addButton],
    paging: options.paging,
    scrollY: "45vh",
    scrollX: true,
    fnCreatedRow: function (nRow, aData, iDataIndex) {
      $(nRow).attr("id", aData[0]);
    },
  });
}
