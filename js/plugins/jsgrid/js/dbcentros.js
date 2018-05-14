(function() {

    var db = {
        loadData: function() {
            var d = $.Deferred();

            $.ajax({
                url: "query/get_centrosjson.php",
                dataType: "json"
            }).done(function(response) {
                console.log(response);
                d.resolve(response);
            });

            return d.promise();
            }
    };

    window.db = db;

    db.empresas = [
        { Nombre: "United States", id: 1 },
        { Nombre: "Canada", id: 2 },
        { Nombre: "United Kingdom", id: 3 },
        { Nombre: "France", id: 4 },
        { Nombre: "Brazil", id: 5 },
        { Nombre: "China", id: 6 },
        { Nombre: "Russia", id: 7 }
    ];


}());