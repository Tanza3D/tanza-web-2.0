const path = require('path');
const fs = require('fs');
const postcssCustomMedia = require('postcss-custom-media');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const srcPath = './src';
const node_modules = "./node_modules";
module.exports = GenerateConfig();

function GenerateConfig() {
    var config = {
        mode: 'development',
        entry: getEntryPoints(),
        plugins: [
            {
                apply: (compiler) => {
                    compiler.hooks.afterEmit.tap('AfterEmitPlugin', (compilation) => {
                        if (fs.existsSync("rev.txt")) {
                            var current_revision = fs.readFileSync("rev.txt");
                        } else {
                            var current_revision = 0;
                        }
                        fs.writeFileSync('rev.txt', (parseInt(current_revision) + 1).toString());
                    });
                }
            },
            new MiniCssExtractPlugin()
        ],
        output: {
            filename: '[name].bundle.js',
            path: path.resolve(__dirname, 'dist'),
        },
        module: {
            rules: [
                {
                    test: /\.css$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {loader: 'css-loader', options: {importLoaders: 1}},
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    plugins: [
                                        require('postcss-custom-media')({
                                            customMedia: {
                                                '--mobile': '(min-width: 601px)',
                                                '--desktop': '(max-width: 600px)',
                                            }
                                        })
                                    ]
                                }
                            }
                        }
                    ]
                },
                {
                    test: /\.(jpe?g|svg|png|gif|ico|eot|ttf|woff2?)(\?v=\d+\.\d+\.\d+)?$/i,
                    type: 'asset/resource',
                },
                {
                    include: path.resolve(__dirname, "node_modules/lucide"),
                    sideEffects: false
                },
            ]
        },
        optimization: {
            nodeEnv: 'production',
            flagIncludedChunks: true,
            usedExports: true,
            concatenateModules: true,
            noEmitOnErrors: true,
            minimize: true,
            removeAvailableModules: true,
            removeEmptyChunks: true,
            mergeDuplicateChunks: true,
        },
        devtool: 'source-map',

    };

    if (process.env["ANTHERA_PRODUCTION"] !== "true") {
        console.log("\x1b[41mCompiling in Development Mode\x1b[0m");
        delete(config.optimization);
        config.plugins.push(
            new BundleAnalyzerPlugin()
        )
    }

    return config;
}


function getEntryPoints() {
    const entryPoints = {};

    // Read entry point from /src/index.js
    entryPoints['index'] = path.resolve(srcPath, 'index.js');
    entryPoints['portfolio'] = path.resolve(srcPath, 'js/views/portfolio.js');

    return entryPoints;
}
