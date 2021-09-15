const path = require("path");

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
            SourceCSS: path.resolve("resources/css"),
        },
    },
};
