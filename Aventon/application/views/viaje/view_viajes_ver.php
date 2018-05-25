
<style>

    body {
        text-align: center;
    }

    #pagination {
        display: inline-block;
        text-align: center;
        margin-top: 10px;
    }

    #pagination a {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
    }

    #pagination a:active {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
    }

    #pagination a:hover {
        background-color: #ddd;
        border-radius: 5px;
    }

</style>

</head>

<body>
    
    <div class="center">
        <h1> Lista de Viajes </h1>

        <div id="table_with_pagination">
            <?php echo $this->table->generate(); ?>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>


