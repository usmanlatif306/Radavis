<style>
    .dt-buttons {
        margin-left: 20px !important;
    }
</style>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({});
    });
</script>
<script type="text/javascript">
    function BulkEdit() {


        check_checked_boxes = $('.all-check:checked');

        var check_checked_boxes = $(".all-check:checked").map(function() {
            return $(this).val();
        }).get();

        $('#bulkeditModal').modal('show');

        $('#ids_to_edit').val('');

        $('#ids_to_edit').val(check_checked_boxes);

    }


    $('#change-log-button').click(function() {


        $('#changeLog').modal('show');


    })
    $(document).ready(function() {
        var table = $('#myTable1').DataTable({
            "oLanguage": {
                "sSearch": "Filter:"
            },
            "bPaginate": false,
            stateSave: true,
            //dom: '<"top"if> rtp'});
            /*dom: 'Bfrtip',
            buttons: [
                'print'
            ],*/
        });
    });

    function format(value) {
        return '<span class="dtr-data">' + value + '</span>';
    }

    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "oLanguage": {
                "sSearch": "Filter:"
            },
            "bPaginate": false,
            stateSave: true,
            dom: '<"top"if>Brtip',
            /*dom: 'Bfrtip',*/
            buttons: [
                'print',
            ],
        });

        $('td').on('click mousedown mouseup', function(e) {
            if (e.target.type === 'checkbox') {
                e.stopPropagation();
            }
        });

        table.on('draw', function() {
            console.log('draw');
        });

        if ('{{ $display_notes }}' === 'show') {
            table.rows().every(function() {
                strAdditional = '<table style="width:100%"><tr>';
                strAdditional = strAdditional +
                    '<td style="width:33%"><span class="dtr-title">Driver</span></td>';
                strAdditional = strAdditional +
                    '<td style="width:33%"><span class="dtr-title">Sales</span></td>';
                strAdditional = strAdditional +
                    '<td style="width:33%"><span class="dtr-title">Accounts</span></td></tr>';
                strAdditional = strAdditional + '<tr><td>';
                strAdditional = strAdditional + format(this.data()[13])
                strAdditional = strAdditional + '</td><td style="width:33%">';
                strAdditional = strAdditional + format(this.data()[14])
                strAdditional = strAdditional + '</td><td style="width:33%">';
                strAdditional = strAdditional + format(this.data()[15])
                strAdditional = strAdditional + '</td></tr></table>';
                this.child(strAdditional).show();
                $(this.node()).addClass('shown');
            });
        }

        $('#myTable').on('click', 'td.details-control', function() {
            // console.log('this is clicked');
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                strAdditional = '<table style="width:100%"><tr>';
                strAdditional = strAdditional +
                    '<td style="width:33%"><span class="dtr-title">Driver</span></td>';
                strAdditional = strAdditional +
                    '<td style="width:33%"><span class="dtr-title">Sales</span></td>';
                strAdditional = strAdditional +
                    '<td style="width:33%"><span class="dtr-title">Accounts</span></td></tr>';
                strAdditional = strAdditional + '<tr><td>';
                if ($(this).closest('tr').find('.driver_instructions').length) {
                    strAdditional = strAdditional + format($(this).closest('tr').find(
                        '.driver_instructions').val())
                }
                strAdditional = strAdditional + '</td><td style="width:33%">';
                if ($(this).closest('tr').find('.sales_notes').length) {
                    strAdditional = strAdditional + format($(this).closest('tr').find('.sales_notes')
                        .val())
                }
                strAdditional = strAdditional + '</td><td style="width:33%">';
                if ($(this).closest('tr').find('.accounting_notes').length) {
                    strAdditional = strAdditional + format($(this).closest('tr').find(
                        '.accounting_notes').val())
                }
                strAdditional = strAdditional + '</td></tr></table>';
                //row.child(format(tr.data('child-value'))).show();
                row.child(strAdditional).show();
                tr.addClass('shown');
            }
        });

        $('#truck_only').on('click', function(e) {
            $('#supplier_only').css('background-color', '#f8f9fc');
            $('#supplier_only').css('color', '#4e73df');

            $('#truck_only').css('background-color', '#4e73df');
            $('#truck_only').css('color', '#f8f9fc');
            e.preventDefault();
            //Get the column API object 2 8 11 12 13 14
            var column0 = table.column(0);
            column0.visible(!column0.visible());
            var column1 = table.column(2); //ID
            column1.visible(!column1.visible());
            var column2 = table.column(5); //PURCHASE
            column2.visible(!column2.visible());
            var column3 = table.column(11); //SALESMAN
            column3.visible(!column3.visible());
            var column4 = table.column(12); //SALES NO
            column4.visible(!column4.visible());
            var column5 = table.column(13); //SET
            column5.visible(!column5.visible());
            var column6 = table.column(14); //DNS
            column6.visible(!column6.visible());
            var column7 = table.column(16); //SALES NOTES
            column7.visible(!column7.visible());
            var column8 = table.column(17); //ACCTG NOTES
            column8.visible(!column8.visible());

        });

        $('#supplier_only').on('click', function(e) {
            $('#truck_only').css('background-color', '#f8f9fc');
            $('#truck_only').css('color', '#4e73df');

            $('#supplier_only').css('background-color', '#4e73df');
            $('#supplier_only').css('color', '#f8f9fc');
            e.preventDefault();
            // Get the column API object 2 4 5 9 10 11 12 13 14
            //var column0 = table.column(0);
            //column0.visible(!column0.visible());
            var column1 = table.column(2);
            column1.visible(!column1.visible());
            var column2 = table.column(4);
            column2.visible(!column2.visible());
            var column3 = table.column(5);
            column3.visible(!column3.visible());
            var column4 = table.column(6);
            column4.visible(!column4.visible());
            var column5 = table.column(9);
            column5.visible(!column5.visible());
            var column6 = table.column(10);
            column6.visible(!column6.visible());
            var column7 = table.column(11);
            column7.visible(!column7.visible());
            var column8 = table.column(12);
            column8.visible(!column8.visible());
            var column9 = table.column(13);
            column9.visible(!column9.visible());
            var column10 = table.column(14);
            column10.visible(!column10.visible());
            var column11 = table.column(15);
            column11.visible(!column11.visible());
            var column12 = table.column(16);
            column12.visible(!column12.visible());
            var column13 = table.column(17);
            column13.visible(!column13.visible());
        });
    });

    function ConfirmDelete(id) {
        $('#deleteModal').modal('show');
        $('#confirm_del_id').val(id);
    }


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function lpad(str, length) {
        var lengthDiff = length - str.length;
        while (lengthDiff > 0) {
            str = '0' + str;
            lengthDiff--;
        }
        return str;
    }





    var timer;
    var x;
    /*$("#release_code").keyup(function () {
        if (x) { x.abort() } // If there is an existing XHR, abort it.
        clearTimeout(timer); // Clear the timer so we don't end up with dupes.
        timer = setTimeout(function() {
            let code = $('#release_code').val();
            // assign timer a new timeout
            x = $.ajax({
                    type: 'POST',
                    url: '{{ route('dispatch.RealseCodeVefiry') }}',
                    "_token": "{{ csrf_token() }}",
                    data: {
                        release_code: code,
                    },
                    success: function(data) {
                            if(data == 1){
                                    $('#add-disptach').attr('disabled','disabled');
                                    $.toaster({ priority :'danger', title :'Release Code', message :'must be unique! Please try a different release code.'});
                            }else if(data == 0) {
                                        //$.toaster({ priority :'success', title :'Perfect', message :'You can save now'});
                                    $('#add-disptach').removeAttr('disabled');
                            }

                    }
                });// run ajax request and store in x variable (so we can cancel)
        }, 500); // 2000ms delay, tweak for faster/slower
    });*/


    /*$('#editreleasecode').keyup(function(){
        let code = $(this).val();
        let dipatchid = $('#dispatch').val();
        if (x) { x.abort() } // If there is an existing XHR, abort it.
            clearTimeout(timer); // Clear the timer so we don't end up with dupes.
            timer = setTimeout(function() {
                x = $.ajax({
                        type: 'POST',
                        url: '{{ route('dispatch.GetReleaseCode') }}',
                        "_token": "{{ csrf_token() }}",
                        data: {
                            release_code: code,
                            existCode: dipatchid
                        },
                        success: function(data) {
                            if(data == 1){
                                $.toaster({ priority :'danger', title :'Release code', message :'must be unique! Please try a different release code.'});
                                $('.edit-button').attr('disabled','disabled');
                            }else if(data == 0) {
                                //$.toaster({ priority :'success', title :'Perfect', message :'You can save now'});
                                $('.edit-button').removeAttr('disabled');
                            }
                        }
                    });
            }, 500);

    })*/

    var edit_supplier = 0;
    var edit_exits = 0;



    function EditDispatch(id) {
        $('#editModal').modal('show');
        $('.edit-button').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.getdispatch') }}',
            "_token": "{{ csrf_token() }}",
            data: {
                dispatch: id
            },
            success: function(data) {
                //console.log(data);
                $('#dispatch').val(data[0].id);
                $('#edit-commoditie').val(data[0].commodity_id);
                $('#edit-commoditie').trigger('change');
                $('#editdate').val(data[0].date);
                $('#editpurchasecode').val(data[0].purchase_code);
                $('#editreleasecode').val(data[0].release_code);
                $('#edit-via').val(data[0].via_id);
                $('#edit-destination').val(data[0].destination_id);
                $('#edit-rate').val(data[0].rate_id);
                $('#edit-salesman').val(data[0].salesman);
                $('#edit-sales_num').val(data[0].sales_num);
                $('#edit_sales_notes').val(data[0].sales_notes);
                $('#edit_accounting_notes').val(data[0].accounting_notes);
                $('#edit_driver_instructions').val(data[0].driver_instructions);
                $('#edit_delivered').val(data[0].delivered);
                $('#edit_noship').val(data[0].noship);
                $('#edit_void').val(data[0].void);
                $('#change-log-button').data('data-ide', data[0].id);
                edit_supplier = data[0].supplier_id;
                edit_exits = data[0].exit_id;
                /*setTimeout(() => {
                    $('#edit-supplier').val(data[0].supplier_id);
                    $('#edit-supplier').trigger('change');
                }, 3000);*/
                /*setTimeout(() => {
                    $('#edit-exits').val(data[0].exit_id);
                    $('.edit-button').removeAttr('disabled');
                }, 5000);*/

            }
        });

        $('#confirm_del_id').val(id);
    }

    function EditUpdateSuppliers() {
        value = $('#edit-commoditie').find(':selected').val();
        if (value) {
            $.ajax({
                type: 'POST',
                url: '{{ route('dispatch.getCommoditieSuppliers') }}',
                "_token": "{{ csrf_token() }}",
                data: {
                    id: value
                },
                success: function(data) {
                    $('#edit-supplier').html(data);
                    $('#edit-supplier').val(edit_supplier);
                    $('#edit-supplier').trigger('change');
                }
            });
        }
    }

    function EditUpdateexits() {
        value = $('#edit-supplier').find(':selected').val();
        if (value) {
            $.ajax({
                type: 'POST',
                url: '{{ route('dispatch.getSuppliersExits') }}',
                "_token": "{{ csrf_token() }}",
                data: {
                    id: value
                },
                success: function(data) {
                    $('#edit-exits').html(data);
                    $('#edit-exits').val(edit_exits);
                    $('.edit-button').removeAttr('disabled');
                }
            });
        }
    }


    function UpdateSuppliers() {
        value = $('#add-commoditie').find(':selected').val();
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.getCommoditieSuppliers') }}',
            "_token": "{{ csrf_token() }}",
            data: {
                id: value
            },
            success: function(data) {
                $('#add-supplier').html(data);
                $('#add-supplier').trigger('change');
            }
        });


    }

    function Updateexits() {
        value = $('#add-supplier').find(':selected').val();
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.getSuppliersExits') }}',
            "_token": "{{ csrf_token() }}",
            data: {
                id: value
            },
            success: function(data) {
                $('#add-exits').html(data);
            }
        });
    }

    function BulkUpdateSuppliers() {
        value = $('.bulk-edit-form #add-commoditie').find(':selected').val();
        console.log(value);
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.getCommoditieSuppliers') }}',
            "_token": "{{ csrf_token() }}",
            data: {
                id: value
            },
            success: function(data) {
                $('.bulk-edit-form #add-supplier').html(data);
                $('.bulk-edit-form #add-supplier').trigger('change');
            }
        });


    }

    function BulkUpdateexits() {
        value = $('.bulk-edit-form #add-supplier').find(':selected').val();
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.getSuppliersExits') }}',
            "_token": "{{ csrf_token() }}",
            data: {
                id: value
            },
            success: function(data) {
                $('.bulk-edit-form #add-exits').html(data);
            }
        });
    }





    function changelog(id) {
        $('#changeLog').modal('show');
        id = $('#change-log-button').data('data-ide');
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.changelog') }}',
            data: {
                dispatch: id
            },
            success: function(data) {
                $('#changelogbody').html(data);

            }
        });
    }


    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + (d.getDate() + 1),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [month, day, year].join('/');
    }
    $('#date_view').change(function() {
        new_date = formatDate($('#date_view').val());
        window.location.href = "{{ url('/') }}/dispatch/searchview?date=" + new_date;
    })


    function ChangeDisptachDisplay() {

        let value = $('#dispatch_display').find(":selected").val();

        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.changedisplay') }}',
            data: {
                value: value
            },
            success: function(data) {

                window.location.href = "";

            }
        });
    }

    function ChangeNotesDisplay() {
        let value = $('#display_notes').find(":selected").val();

        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.displaynotes') }}',
            data: {
                value: value
            },
            success: function(data) {
                window.location.href = "";
            }
        });
    }



    $(document).ready(function() {
        var today = new Date();
        $('#datepicker_from').val(today.toISOString().substr(0, 10));
        $('#datepicker_to').val(today.toISOString().substr(0, 10));
        $("#datepicker_all").change(function() {
            updateUI();
        });
        // setTimeout(() => {
        //     updateUI();
        // }, 1000);



    });

    function updateUI() {
        if ($('#datepicker_all').is(':checked')) {
            $('#datepicker_from').attr('disabled', 'disabled');
            $('#datepicker_to').attr('disabled', 'disabled');
        } else {
            $('#datepicker_from').removeAttr('disabled');
            $('#datepicker_to').removeAttr('disabled');
        }
    }


    $('#add-disptach').click(function() {

        let relcode = $('#release_code_new').val();

        // assign timer a new timeout
        if (relcode != "") {
            x = $.ajax({
                type: 'POST',
                url: '{{ route('dispatch.RealseCodeVefiry') }}',
                "_token": "{{ csrf_token() }}",
                data: {
                    release_code: relcode,
                },
                success: function(data) {
                    if (data == 1) {
                        //$('#add-disptach').attr('disabled','disabled');
                        //$.toaster({ priority :'danger', title :'Release Code', message :'must be unique! Please try a different release code.'});
                        $('#createModal').modal('hide');
                        $('#confirnewmmodal').modal('show');
                    } else if (data == 0) {
                        //$.toaster({ priority :'success', title :'Perfect', message :'You can save now'});
                        // $('#add-disptach').removeAttr('disabled');
                        $('#disptach-form').submit();
                    }

                }
            }); // run ajax request and store in x variable (so we can cancel)
        } else {
            $('#disptach-form').submit();
        }



    });

    $('#confirm_new_yes').click(function() {
        $('#confirnewmmodal').modal('hide');
        $('#createModal').modal('show');
        $('#disptach-form').submit();

    });

    $('#confirm_new_cancel').click(function() {
        $('#confirnewmmodal').modal('hide');

        setTimeout(function() {
            $('#createModal').modal('show');
        }, 500);
        //$('body').addClass('modal-open');
    });


    $('#confirm_edit_yes').click(function() {
        $('#confirmeditmmodal').modal('hide');
        $('#editModal').modal('show');
        $('#frmEdit').submit();

    });

    $('#confirm_edit_cancel').click(function() {
        $('#confirmeditmmodal').modal('hide');

        setTimeout(function() {
            $('#editModal').modal('show');
        }, 500);
        //$('body').addClass('modal-open');
    });


    $('.edit-button').click(function(event) {
        event.preventDefault();
        let code = $('#editreleasecode').val();
        let dipatchid = $('#dispatch').val();
        if (code != "") {
            $.ajax({
                type: 'POST',
                url: '{{ route('dispatch.GetReleaseCode') }}',
                "_token": "{{ csrf_token() }}",
                data: {
                    release_code: code,
                    existCode: dipatchid
                },
                success: function(data) {
                    if (data == 1) {
                        console.log("in if");
                        $('#editModal').modal('hide');
                        $('#confirmeditmmodal').modal('show');
                        //$.toaster({ priority :'danger', title :'Realse code', message :'Must be unique'});
                    } else if (data == 0) {
                        console.log('form submit');
                        $('#frmEdit').submit();
                        //$('.edit-button').removeAttr('disabled');
                        //$('#disptach-form').submit();
                        //$.toaster({ priority :'success', title :'Perfect', message :'You can save now'});
                    }
                }
            });
        } else {
            $('#frmEdit').submit();
        }

    });

    /*$('#editreleasecode').blur(function(){
        let code = $('#editreleasecode').val();
        let dipatchid = $('#dispatch').val();
        $.ajax({
            type: 'POST',
            url: '{{ route('dispatch.GetReleaseCode') }}',
            "_token": "{{ csrf_token() }}",
            data: {
                release_code: code,
                existCode: dipatchid
            },
            success: function(data) {
                if(data == 1){
                    $.toaster({ priority :'danger', title :'Realse code', message :'Must be unique'});
                }else if(data == 0) {
                    $('.edit-button').removeAttr('disabled');
                    //$('#disptach-form').submit();
                    //$.toaster({ priority :'success', title :'Perfect', message :'You can save now'});
                }
            }
        });

    });*/
    /*let code = $('#editreleasecode').val();
    let release_code = $('#release_code').val();
    let dipatchid = $('#dispatch').val();
    $.ajax({
                type: 'POST',
                url: '{{ route('dispatch.GetReleaseCode') }}',
                "_token": "{{ csrf_token() }}",
                data: {
                    release_code: code,
                    existCode: dipatchid
                },
                success: function(data) {
                    if(data == 1){
                        $.toaster({ priority :'danger', title :'Realse code', message :'Must be unique'});
                    }else if(data == 0) {
                        $('#disptach-form').submit();
                        //$.toaster({ priority :'success', title :'Perfect', message :'You can save now'});
                    }
                }
            });*/


    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            for (j = 0; j < acc.length; j++) {
                console.log(i);
                console.log(j);
                if (acc[j] != this) {
                    if (acc[j].classList.contains("active")) {
                        acc[j].classList.remove("active");
                        var panel = acc[j].nextElementSibling;
                        panel.style.display = "none";
                    }
                }


            }
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
