<script src="{{ asset('js/vendor.bundle.js') }}"></script>
<script src="{{ asset('js/theme.bundle.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<!--Sweet Alert 2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Ui Script -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript">
    /**
     * Creates a DataTable with the specified columns.
     *
     * @param {Array} columns - An array of column names to display in the table.
     * @returns {Object} - A DataTable object.
     */


    function createDataTable(columns) {
        const colDefs = columns.map(col => ({
            data: col,
            name: col,
            className: 'text-center align-middle'
        }));

        return $('#TabledataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            stateSave: true,
            pageLength: 10,
            fixedHeader: true,
            ajax: {
                url: window.location.href, // your endpoint
                type: 'GET',               // or POST if needed
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF token
                },
                data: function(d) {
                    // You can also pass extra parameters here
                    // Example: d.scope = $('#scope-select').val();
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTable Ajax Error:', xhr.responseText);
                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
                { data: 'id', name: 'id', className: 'text-center' },
                ...colDefs,
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
            ],
            order: [[1, 'desc']],
            dom:
                "<'row mb-3'<'col-sm-6 d-flex align-items-center'B><'col-sm-6'f>>" +  // buttons + filter
                "<'row'<'col-12'tr>>" +                                               // table
                "<'row mt-3'<'col-sm-5 btn btn-warning dropdown'l><'col-sm-7'p>>"      ,

            buttons: ['copy','excel','pdf','print'],
            preDrawCallback: function() { $('#spinner').show(); },
            drawCallback: function() { $('#spinner').hide(); },
        });
    }




    /**
     * Submits a form using AJAX and reloads a DataTable.
     *
     * @param {string} id - The ID of the form element.
     * @param {string} model - The ID of the modal element.
     */
    function updateOrCreate(id, model) {
        // Submit form when it is submitted
        $(id).submit(function (e) {
            e.preventDefault(); // Prevent the default form submit action

            // Create a FormData object to store the form data
            var formData = new FormData(this);

            // Send an AJAX request to the server to create or update data
            $.ajax({
                type: 'POST', // HTTP request method
                dataType: 'json', // Data format to send and receive
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json'}, // Request headers
                url: window.location.pathname, // Request URL
                data: formData, // Data to send
                cache: false, // Disable caching
                contentType: false, // Do not set content type
                processData: false, // Do not process data
                error: (data) => { // Function to execute on error
                    console.log('Error:', data.responseJSON.errors);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicated Data entered!!',
                    });
                },
                success: (data) => { // Function to execute on success
                    console.log('Success:', data);
                    $(model).modal('hide'); // Hide the modal
                    $("#btn-submit").html('Submit'); // Set the button text to 'Submit'
                    alertNow('success', data.message); // Show a success message
                },
            });

            table.ajax.reload(); // Reload the DataTable
        });
    }

    /**
     * Deletes a record using AJAX and reloads a DataTable.
     *
     * @param {number} id - The ID of the record to delete.
     * @param {string} Model - The name of the model for the record.
     */
    function destroy(id, Model) {
        var slug = Model.toLowerCase() + "s"; // Create a slug for the model

        // Confirm that the user wants to delete the record
        if (confirm('Are you sure?')) {
            // Send an AJAX request to the server to delete the record
            $.ajax({
                type: 'POST', // HTTP request method
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'}, // Request headers
                url: "/" + slug + "/" + id, // Request URL
                method: 'DELETE', // HTTP request method
                success: (data) => { // Function to execute on success
                    console.log('Success:', data);
                    alertNow('success', data.message); // Show a success message
                },
            });
            table.ajax.reload(); // Reload the DataTable
            alertNow('success', 'Record deleted successfully'); // Show a success message
        }
    }


    /**
     * Permanently deletes a record using AJAX and reloads a DataTable.
     *
     * @param {number} id - The ID of the record to delete.
     * @param {string} Model - The name of the model for the record.
     */
    function forceDelete(id, Model) {
        var slug = Model.toLowerCase() + "s"; // Create a slug for the model

        // Confirm that the user wants to permanently delete the record
        if (confirm('Are you sure you want to permanently delete this record? This action cannot be undone.')) {
            // Send an AJAX request to the server to permanently delete the record
            $.ajax({
                type: 'POST', // HTTP request method
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'}, // Request headers
                url: "/forceDelete", // Request URL
                data: { id: id ,slug:slug, _method: 'DELETE' }, // Request data
                success: (data) => { // Function to execute on success
                    console.log('Success:', data);
                    alertNow('success', data.message); // Show a success message
                },
            });
            table.ajax.reload(); // Reload the DataTable
            alertNow('success', 'Record deleted permanently.'); // Show a success message
        }
    }


    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Mass Destroy Script
     * --------------------------------------------
     * @param {string} Model - The name of the model for the record.
     */
    function massDestroy(Model) {
        // Create slug for the model
        const slug = Model.toLowerCase() + "s";

        // Create model path
        const model = "\\App\\Models\\" + Model;

        // Get the ids of the records that are checked
        const ids = Array.from($('.checkbox:checked')).map((checkbox) => checkbox.value);

        // Check if any record is selected
        if (ids.length === 0) {
            alert('Zero Record Selected!!!');
            return;
        }

        // Confirm with the user before deleting records
        if (confirm('Are you sure?')) {
            $.ajax({
                type: 'POST',
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                url: '/massDestroy',

                // Send the ids, model slug and model name as data to the server
                data: {
                    ids: ids,
                    slug: slug,
                    model: model,
                    _method: 'DELETE'
                },
                success: (data) => {
                    console.log('Success:', data);
                    alertNow('success', data.message);
                },
            });

            // Reload the data table
            table.ajax.reload();
        }
    }

    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Mass Force Delete Script
     * --------------------------------------------
     * --------------------------------------------
     */
    function massForceDelete(Model){
        var slug=Model.toLowerCase()+"s";
        var model="\\App\\Models\\"+Model;
        var ids = [];
        $('.checkbox:checked').each(function(){
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            alert('Zero Record Selected!!!')
            return
        }

        if (confirm('Are you Sure?')) {
            $.ajax({
                type: 'POST',
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'},
                url: "/massForceDelete",
                data: { ids: ids,slug:slug, model:model, _method: 'DELETE' },
                success: (data) => {
                    console.log('Success:', data);
                    alertNow('success', data.message);
                },
            })
            table.ajax.reload();
        }
    }
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Mass Restore Script
     * --------------------------------------------
     * --------------------------------------------
     */
    function massRestore(Model) {
        // Construct the slug and model strings for the request
        const slug = Model.toLowerCase() + "s";
        const model = "\\App\\Models\\" + Model;

        // Get an array of all the selected record IDs
        const selectedIds = getSelectedRecordIds();

        // If no records are selected, show an alert and return
        if (selectedIds.length === 0) {
            alert("No records selected.");
            return;
        }

        // Confirm the restore action with the user
        if (confirm("Are you sure you want to restore the selected records?")) {
            // Send a POST request to the server to restore the selected records
            $.ajax({
                type: "POST",
                headers: {
                    "x-csrf-token": $('meta[name="csrf-token"]').attr("content"),
                    Accept: "application/json",
                },
                url: "/massRestore",
                data: {
                    ids: selectedIds,
                    slug: slug,
                    model: model,
                    _method: "POST",
                },
                success: (data) => {
                    console.log("Success:", data);
                    alertNow("success", data.message);
                },
            });
            // Reload the data table after the restore action is complete
            table.ajax.reload();
        }

        // Get an array of all the IDs of the selected records
        function getSelectedRecordIds() {
            const selectedIds = [];
            $(".checkbox:checked").each(function () {
                selectedIds.push($(this).val());
            });
            return selectedIds;
        }
    }

    /**
     * Performs a restore operation for a given record using an AJAX request.
     *
     * @param {string} id - The ID of the record to restore.
     * @param {string} Model - The name of the model class for the record.
     */
    function restore(id, Model) {
        // Derive the slug and model name for the record based on the supplied Model parameter.
        var slug = Model.toLowerCase() + "s";
        var model = "\\App\\Models\\" + Model;

        // Send an AJAX POST request to the server to perform the restore operation.
        $.ajax({
            type: 'POST',
            headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'},
            url: "/restore",
            data: {id: id, slug: slug, model: model, _method: 'POST'},
            success: (data) => {
                // If the restore operation was successful, log a success message to the console and display a success toast notification.
                console.log('Success:', data);
                alertNow('success', data.message);
            },
        })

        // Reload the table data using an AJAX request to ensure that the restored record is displayed.
        table.ajax.reload();
    }



    /**
     * Displays a toast notification using SweetAlert2.
     *
     * @param {string} label - The label for the toast, which determines the icon to display.
     * @param {string} action - The message to display in the toast.
     */
    function alertNow(label, action) {
        // Create a new Toast instance using SweetAlert2.
        const Toast = Swal.mixin({
            toast: true,                  // Display the toast as a notification.
            position: 'top-end',          // Position the toast at the top-right corner of the screen.
            showConfirmButton: false,     // Do not display a confirmation button.
            timer: 3000,                  // Automatically close the toast after 3 seconds.
            timerProgressBar: true,       // Display a progress bar indicating the remaining time.
            didOpen: (toast) => {
                // Pause the timer when the user hovers over the toast.
                toast.addEventListener('mouseenter', Swal.stopTimer)
                // Resume the timer when the user moves the mouse away from the toast.
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        // Display the toast notification.
        Toast.fire({
            icon: label,   // Set the icon for the toast based on the label.
            title: action  // Set the message for the toast.
        })
    }

</script>
<!-- Additional Scripts -->
@yield('scripts')
<script type="text/javascript">
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Scroll Arrow Script
     * --------------------------------------------
     * --------------------------------------------
     */
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });
</script>
<script>
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Search Script
     * --------------------------------------------
     * --------------------------------------------
     */
    $('.searchable-field').select2({
        theme: "classic",
        minimumInputLength: 3,
        ajax: {
            url: '{{ route("home") }}',
            dataType: 'json',
            type: 'GET',
            delay: 200,
            data: function (term) {
                return {
                    search: term
                };
            },
            results: function (data) {
                return {
                    data
                };
            }
        },
        escapeMarkup: function (markup) { return markup; },
        templateResult: formatItem,
        templateSelection: formatItemSelection,
        placeholder : 'Global Search',
        language: {
            inputTooShort: function(args) {
                var remainingChars = args.minimum - args.input.length;
                var translation = 'Search input is too short';

                return translation.replace(':count', remainingChars);
            },
            errorLoading: function() {
                return 'errorr loading results';
            },
            searching: function() {
                return 'global searching';
            },
            noResults: function() {
                return 'no result';
            },
        }

    });
    function formatItem (item) {
        if (item.loading) {
            return 'global searching';
        }
        var markup = "<div class='searchable-link' href='" + item.url + "'>";
        markup += "<div class='searchable-title'>" + item.model + "</div>";
        $.each(item.fields, function(key, field) {
            markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " + item[field] + "</div>";
        });
        markup += "</div></div>";

        return markup;
    }

    function formatItemSelection (item) {
        if (!item.model) {
            return 'global search';
        }
        return item.model;
    }

    $(document).delegate('.searchable-link', 'click', function() {
        var url = $(this).attr('href');
        window.location = url;
    });

    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Get the model scopes
     * --------------------------------------------
     * --------------------------------------------
     */

    // Fetch available scopes and populate the select tag
    if (document.getElementById('scope-select')) {
        $.get(window.location.pathname + '/create?scopes=', function (scopes) {
            $.each(scopes, function (index, scope) {
                $('#scope-select').append($('<option>', {
                    value: scope,
                    text: scope
                }));
            });
        });

        // Refresh the DataTable when a scope is selected
        $('#scope-select').on('change', function () {
            var scope = $(this).val();
            if (scope === '') {
                table.ajax.url(window.location.pathname).load();
            } else {
                table.ajax.url(window.location.pathname + '?scope=' + encodeURIComponent(scope)).load();
            }
        });
    }


    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Select Deselect Records Script
     * --------------------------------------------
     * --------------------------------------------
     */
    $('#select-toggle').click(function() {
        var checkboxes = $('td:nth-child(1) input[type="checkbox"]');
        checkboxes.prop('checked', !checkboxes.prop('checked'));

        // Change button icon based on whether any checkboxes are checked
        var buttonIcon = $('#select-toggle i');
        if (checkboxes.filter(':checked').length > 0) {
            buttonIcon.removeClass('far fa-square');
            buttonIcon.addClass('fas fa-check-square');
        } else {
            buttonIcon.removeClass('fas fa-check-square');
            buttonIcon.addClass('far fa-square');
        }
    });


</script>
