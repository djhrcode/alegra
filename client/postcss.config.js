const purgeCssPlugin = require("@fullhuman/postcss-purgecss");
const vuePath = /\.vue(\?.+)?$/;

module.exports = {
    plugins: [
        // purgeCssPlugin({
        //     contentFunction: (sourceInputFile) => {
        //         if (vuePath.test(sourceInputFile)) {
        //             return [sourceInputFile.replace(vuePath, ".vue")];
        //         }
        //         return ["src/**/*.vue", "index.html"];
        //     },
        // }),
    ],
};
