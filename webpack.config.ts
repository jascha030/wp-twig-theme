import MiniCssExtractPlugin from 'mini-css-extract-plugin'
import * as path from 'path'
import * as webpack from 'webpack'
import WebpackModes from './src/typescript/Enum/Webpack/WebpackModes'

const production: boolean = process.env.NODE_ENV === WebpackModes.Production

const entry: webpack.Entry = {
  main: path.resolve(__dirname, 'src/index.ts'),
  style: path.resolve(__dirname, 'src/scss/main.scss')
}

const output: any = {
  path: path.resolve('theme/dist'),
  publicPath: '/app/themes/wp-twig-theme/theme/dist',
  filename: '[name].js',
  chunkFilename: production ? '[contenthash].js' : '[id].js',
  clean: true
}

const module: webpack.ModuleOptions = {
  rules: [
    {
      test: /\.(s[ac]|c)ss$/i,
      exclude: /node_modules/,
      use: [
        MiniCssExtractPlugin.loader,
        { loader: 'css-loader', options: { importLoaders: 1 } },
        'postcss-loader',
        'sass-loader'
      ]
    }
  ]
}

const config: webpack.Configuration = {
  mode: production ? WebpackModes.Production : WebpackModes.Development,
  entry,
  output,
  devtool: 'source-map',
  module,
  resolve: { extensions: ['.ts', '.js'] },
  watch: !production
}

export default config
