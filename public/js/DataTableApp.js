function DataTableApp($table, $input, $loader) {

    var departements = [];
    this.loader = $loader;
    this.input = $input;
    this.table = $table.DataTable({
        "language": {
            "url": "/lang/French.json",
        },
    });

    this.input.prop('disabled', true);
    this._loadDepartements().then((data) => {
        data.forEach((element, index) => {
          departements.push(element.departement)
        });
        this.input.prop('disabled', false);
    }).then(() => {
        this.input.autocomplete({
            source: departements,
            select: (event, ui) => {
                    let promise = new Promise((resolve, reject) => {
                        this.loader.show();
                        $table.hide();
                        // empty table
                        this.table.destroy();
                        // refills table
                        this.table = $table.DataTable({
                            "language": {
                                "url": "/lang/French.json"
                            },
                            'ajax': '/api/villes/' + ui.item.value,
                            'columns': [
                                { 'data': 'nom'},
                                { 'data': 'codepostal'},
                                { 'data': 'INSEE'}
                            ]
                        });
                        setTimeout(() => {
                            resolve();
                        }, 500)
                    });
                promise.then(() => {
                    this.loader.hide();
                    $table.show();
                })

                }
            })
        })
}

DataTableApp.prototype._loadDepartements = () => {
    return $.ajax({
        url: '/api/departements',
        dataType: 'json',
        method: 'get'
    }).done((data) => {
        //
    }).fail((xhr) => {
        console.log('Error : ' + xhr.responseJSON.error);
    });
};
