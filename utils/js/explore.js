'use strict';

// We'll need some way to show errors
let errorDiv = document.querySelector('.error-div');
let errorMessage = document.querySelector('#error-message');

// Make gridOptions global so we can access it from the download button
let gridOptions;

// Assume there's a form with an id of "searchForm" and a select with an id of "search_table"
document.querySelector('#searchForm').addEventListener('submit', function (event) {
  event.preventDefault();

  let searchTable = document.querySelector('#search_table').value;

  // Create a new XMLHttpRequest
  let xhr = new XMLHttpRequest();

  // Configure it: GET-request for the URL /getTableData.php?searchTable=<value>
  xhr.open('GET', '/utils/getTableData.php?searchTable=' + encodeURIComponent(searchTable), true);

  xhr.onload = function () {
    if (xhr.status == 200) {
      // The server should return the data in JSON format
      let data = JSON.parse(xhr.responseText);

      // Display the results
      let resultsContainer = document.querySelector('.results-container');
      resultsContainer.innerHTML = "<p>" + data.length + " result(s) found</p>";

      // Check if data has free_download
      if (data[0].hasOwnProperty('free_download')) {
        // If so, for each entry that has free_download=1, change the unique_name to a link
        for (let i = 0; i < data.length; i++) {
          if (data[i].free_download == 1) {
            data[i].unique_name = "<a href='download.php?name=" + data[i].file_id + "'>" + data[i].unique_name + "</a>";
          }
          // Remove free_download from each row
          delete data[i].free_download;
        }
      }

      // Check if data has file_id
      if (data[0].hasOwnProperty('file_id')) {
        // If so, remove file_id from each row
        for (let i = 0; i < data.length; i++) {
          delete data[i].file_id;
        }
      }

      // Generate column names for ag-grid
      let columnNames = [];
      for (let key in data[0]) {
        let column = {
          headerName: key,
          field: key
        };

        // Check if the column can be a number
        if (data[0][key] != null && !isNaN(data[0][key])) {
          column.type = 'numericColumn';
          // Enable checking values using math comparison operators
          column.filter = 'agNumberColumnFilter';
        }

        if (key === 'unique_name') {
          column.cellRenderer = function (params) {
            if (params.data.free_download == 1) {
              return "<a href='download.php?name=" + params.value + "'>" + params.value + "</a>";
            } else {
              return params.value;
            }
          }
        }

        columnNames.push(column);
      }

      // Generate the grid
      gridOptions = {
        columnDefs: columnNames,
        rowData: data,
        pagination: true,
        paginationPageSize: 50,
        domLayout: 'autoHeight',
        defaultColDef: {
          resizable: true,
          sortable: true,
          filter: true
        }
      };

      // Destroy the old grid if it exists
      if (document.querySelector('#my-grid').hasChildNodes()) {
        document.querySelector('#my-grid').removeChild(document.querySelector('#my-grid').firstChild);
      }

      // Set grid to display: initial;
      document.querySelector('#my-grid').style.display = 'initial';

      // Create the grid
      new agGrid.Grid(document.querySelector('#my-grid'), gridOptions);

      // Auto-size all columns
      const allColumnIds = [];
      gridOptions.columnApi.getColumns().forEach((column) => {
        allColumnIds.push(column.getId());
      });

      gridOptions.columnApi.autoSizeColumns(allColumnIds, true);

      // Clear any previous error
      errorDiv.style.display = 'none';
    } else {
      // If there's an error, show it
      errorMessage.textContent = 'Error: ' + xhr.status;
      errorDiv.style.display = 'block';
    }
  };

  xhr.onerror = function () {
    // If there's an error, show it
    errorMessage.textContent = 'Request failed';
    errorDiv.style.display = 'block';
  };

  // Send the request over the network
  xhr.send();
});


document.getElementById("download-csv").addEventListener("click", function () {
  // Show the modal
  document.getElementById('downloadModal').style.display = "block";
});

// Confirm Download button event
document.getElementById("confirmDownload").addEventListener("click", function () {
  let csvContent = gridOptions.api.getDataAsCsv();

  if (csvContent) {
    // Create a link and click it
    let encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
    let link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "data.csv");
    document.body.appendChild(link);
    link.click();
  }
  else {
    // If data is not populated, show an error
    errorMessage.textContent = 'Error: No data to download';
    errorDiv.style.display = 'block';
  }

  // Hide the modal
  document.getElementById('downloadModal').style.display = "none";
});

// Cancel Download button event
document.getElementById("exitModal").addEventListener("click", function () {
  // Hide the modal
  document.getElementById('downloadModal').style.display = "none";
});