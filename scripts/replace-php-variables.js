const fs = require('fs');
const files = [
    'account.tpl'
];

for (var i = 0; i < files.length; i++) {
    var file = './src/upload/catalog/view/theme/default/template/mail/' + files[i];

    fs.readFile(file, 'utf8', function (err, data) {
        if (err) {
            return console.log(err);
        }

        var result = data.replace(/\[\[(.*?)\]\]/g, '<?php echo $$$1; ?>');

        fs.writeFile(file, result, 'utf8', function (err) {
            if (err) return console.log(err);
        });
    });
}

