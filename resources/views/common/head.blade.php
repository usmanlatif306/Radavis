<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RAD Dispatch</title>

    {{-- ICON --}}
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/icon.png') }}" />

    <!-- Font Awesome UI KIT-->
    <script src="https://kit.fontawesome.com/f75ab26951.js" crossorigin="anonymous"></script>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">


    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.16/moment-timezone-with-data.min.js"></script>

    <style>
        .dataTable {
            width: 98% !important;
        }

        #DataTables_Table_0_wrapper {
            padding: 20px !important
        }

        .select2-container {
            width: 100% !important;
        }

        .form-control {
            font-size: 0.75rem !important;
        }

        body {
            font-size: 0.75rem !important;
        }


        /* Style the buttons that are used to open and close the accordion panel */
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: 0.4s;
        }

        /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
        .active,
        .accordion:hover {
            background-color: #ccc;
        }

        /* Style the accordion panel. Note: hidden by default */
        .panel {
            padding: 0 18px;
            background-color: white;
            display: none;
            overflow: hidden;
        }

        button.accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .ck-content {
            min-height: 250px !important;
        }
    </style>
    @stack('styles')

</head>
