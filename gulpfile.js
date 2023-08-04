/*
npm init -y
↓
npm i -D gulp browser-sync gulp-ejs gulp-html-beautify gulp-connect-php gulp-notify gulp-plumber gulp-rename gulp-replace sass gulp-sass gulp-sass-glob gulp-sass-glob-use-forward gulp-autoprefixer css-declaration-sorter gulp-clean-css gulp-purgecss gulp-uglify gulp-imagemin@7.1.0 imagemin-mozjpeg@9.0.0 imagemin-pngquant@9.0.1 imagemin-svgo@9.0.0 gulp-watch
↓
npx gulp
==============================================================*/

//変数設定
//-------------------------------------------------------------------------------
//パッケージ群
const browserSync = require('browser-sync');
const connect = require('gulp-connect-php');
const gulp = require('gulp');
const ejs = require('gulp-ejs'); //EJS
const fs = require('fs');//JSONファイル操作用
const { dest, series } = require('gulp');
const replace = require('gulp-replace'); 
const htmlbeautify = require('gulp-html-beautify'); //HTML生成後のコードを綺麗にする
const plumber = require('gulp-plumber'); //停止制御
const notify = require('gulp-notify'); //エラー通知
const uglify = require('gulp-uglify'); //JavaScriptファイルを圧縮
const rename = require('gulp-rename'); //ファイルの変更
const imagemin = require('gulp-imagemin'); //画像圧縮
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminPngquant = require('imagemin-pngquant');
const imageminSvgo = require('imagemin-svgo');
const sass = require('gulp-sass')(require('sass')); // sassのコンパイル
const sassGlob01 = require('gulp-sass-glob'); //sass一括インポート
const sassGlob02 = require('gulp-sass-glob-use-forward'); //sass一括インポート
const autoprefixer = require('gulp-autoprefixer');//ベンダープレフィックス自動付与
const watch = require('gulp-watch'); //監視
//入力ファイル指定
const src = {
  ejs: ['./_src/**/*.ejs', '!' + './_src/**/_*.ejs'],
  json: ['./_src/json/**/*.json'],
	sass: './_src/scss/**/*.scss',
	js: './_src/js/*.js',
	image: './_src/img/**/*.{png,jpg,gif,svg}',
}

//出力ファイル指定
const dst = {
	html: './dist/',
	css: './dist/css',
	js: './dist/js',
	image: './dist/img',
}

//ブラウザーシンク　更新するたびに同期
//-------------------------------------------------------------------------------
const connectSync = (done) => {
	//local wordpress↓
  connect.server({
		port: 3000,
		base: 'dist'
	}, () => {
		//local wordpress↑
    browserSync.init({
      // ローカルサーバー
      proxy: 'localhost:3000',
      notify: false,                    // ブラウザ更新時に出てくる通知を非表示にする
      open: "external", 
		});
		//local wordpress↓
	});
	//local wordpress↑
  done();
}
exports.task = connectSync;

const reload = (done) => {
  browserSync.reload();
  done();
}
exports.task = reload;


//EJSルコンパイル
//-------------------------------------------------------------------------------
const compileHtml = () => {
  const data = JSON.parse(fs.readFileSync('./_src/json/data.json'));
  return gulp
    .src(src.ejs)
    .pipe(plumber({ errorHandler: notify.onError("Error: <%= error.message %>") }))//エラーチェック
    .pipe(ejs(data))
    .pipe(rename({ extname: '.html' }))
		//browsersyncを使用しないときはコメントアウト↓
		.pipe(browserSync.reload({ stream: true }))
		//browsersyncを使用しないときはコメントアウト↑
    .pipe(dest(dst.html)); //出力先
}
exports.task = compileHtml;

//scssファイルコンパイル
//-------------------------------------------------------------------------------
const compileSass = () => {
  return gulp
    .src(src.sass)// scssフォルダー以下に保存
		.pipe(
      plumber({ //エラーが出ても処理を止めない
        errorHandler: notify.onError('Error: <%= error.message %>') 
      }))
    .pipe(sassGlob01())
    .pipe(sassGlob02())
    .pipe(
      sass({
        outputStyle: 'compressed' //nested expanded compact compressed　この４つから選択
      })
    )
    .pipe(
      autoprefixer([ // ベンダープレフィックス自動付与
        'last 2 versions',//各ブラウザの2世代前までのバージョンを担保
        'ie >= 11'//IE11を担保
      ])
    ) 
		//browsersyncを使用しないときはコメントアウト↓
		.pipe(browserSync.reload({ stream: true }))
		//browsersyncを使用しないときはコメントアウト↑
    .pipe(dest(dst.css)) // cssフォルダー以下に保存
} 
exports.task = compileSass;


//jsファイルコンパイル
//-------------------------------------------------------------------------------
const compileJs = () => {
  return gulp
    .src(src.js)
    .pipe(plumber())
    .pipe(uglify())
    .pipe(rename({
        extname: '.min.js'
    }))
  //browsersyncを使用しないときはコメントアウト↓
  .pipe(browserSync.reload({ stream: true }))
  //browsersyncを使用しないときはコメントアウト↑
  .pipe(dest(dst.js));
}
exports.task = compileJs;


//画像圧縮
//-------------------------------------------------------------------------------
const images = () => {
  return gulp
    .src(src.image)
    .pipe(plumber())
    .pipe(imagemin([
      imageminMozjpeg({
        quality: 80
      }),
      imageminPngquant(),
      imageminSvgo({
        plugins: [{
          removeViewbox: false
        }]
      }),
      imagemin.optipng(),
      imagemin.gifsicle()
    ]))
		//browsersyncを使用しないときはコメントアウト↓
		.pipe(browserSync.reload({ stream: true }))
		//browsersyncを使用しないときはコメントアウト↑
		.pipe(dest(dst.image));
}
exports.task = images;


//タスクを監視
//-------------------------------------------------------------------------------
const checkWatch = (done) => {
  gulp.watch(['./_src/**/*.ejs', '!' + './_src/**/_*.ejs', './_src/json/**/*.json'], compileHtml);
  gulp.watch(src.sass, compileSass);
  gulp.watch(src.js, compileJs);
  gulp.watch(src.image, images);
  gulp.watch('dist/**/*.html', reload);
  done();
}
exports.task = checkWatch;

exports.default = series(connectSync, compileHtml, compileSass, images, compileJs, checkWatch);
