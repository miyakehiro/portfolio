import browserSync from 'browser-sync';
import connect from 'gulp-connect-php';
import gulp from 'gulp';
import ejs from 'gulp-ejs';
import fs from 'fs';
import plumber from 'gulp-plumber';
import notify from 'gulp-notify';
import uglify from 'gulp-uglify';
import rename from 'gulp-rename';
import imagemin from 'gulp-imagemin';
import imageminMozjpeg from 'imagemin-mozjpeg';
import imageminPngquant from 'imagemin-pngquant';
import imageminSvgo from 'imagemin-svgo';
import gulpSass from 'gulp-sass';
import sassCompiler from 'sass';

const sass = gulpSass(sassCompiler);



// 入出力ファイル指定
const src = {
  ejs: ['./_src/**/*.ejs', '!' + './_src/**/_*.ejs'],
  json: ['./_src/json/**/*.json'],
  sass: './_src/scss/**/*.scss',
  js: './_src/js/*.js',
  image: './_src/img/**/*.{png,jpg,gif,svg}',
};

const dst = {
  html: './dist/',
  css: './dist/css',
  js: './dist/js',
  image: './dist/img',
};

// ブラウザシンク
const connectSync = (done) => {
  connect.server({ port: 3000, base: 'dist' }, () => {
    browserSync.init({
      proxy: 'localhost:3000',
      notify: false,
      open: 'external',
    });
  });
  done();
};

// HTMLコンパイル（EJS）
const compileHtml = () => {
  const data = JSON.parse(fs.readFileSync('./_src/json/data.json'));
  return gulp
    .src(src.ejs)
    .pipe(plumber({ errorHandler: notify.onError('Error: <%= error.message %>') }))
    .pipe(ejs(data))
    .pipe(rename({ extname: '.html' }))
    .pipe(browserSync.stream())
    .pipe(gulp.dest(dst.html));
};

// Sassコンパイル
const compileSass = () => {
  return gulp
    .src('./_src/scss/**/*.scss')
    .pipe(plumber({ errorHandler: notify.onError('Error: <%= error.message %>') }))
    .pipe(sass({ outputStyle: 'expanded' }))
    .pipe(gulp.dest('./dist/css'))
    .pipe(browserSync.stream());
};


// JSファイルの圧縮
const compileJs = () => {
  return gulp
    .src(src.js)
    .pipe(plumber())

    // 通常版JSの出力
    .pipe(rename({ extname: '.js' }))
    .pipe(gulp.dest(dst.js))

    // 圧縮版JSの出力
    .pipe(uglify())
    .pipe(rename({ extname: '.min.js' }))
    .pipe(gulp.dest(dst.js))
    .pipe(browserSync.stream());
};

// 画像圧縮
const images = () => {
  return gulp
    .src(src.image)
    .pipe(plumber())
    .pipe(
      imagemin([
        imageminMozjpeg({ quality: 80 }),
        imageminPngquant(),
        imageminSvgo({ plugins: [{ removeViewBox: false }] }),
      ])
    )
    .pipe(browserSync.stream())
    .pipe(gulp.dest(dst.image));
};

// ファイル監視
const watchFiles = (done) => {
  gulp.watch(src.ejs, compileHtml);
  gulp.watch(src.json, compileHtml);
  gulp.watch(src.sass, compileSass);
  gulp.watch(src.js, compileJs);
  gulp.watch(src.image, images);
  gulp.watch('dist/**/*.html').on('change', browserSync.reload);
  done();
};

// デフォルトタスク
export default gulp.series(connectSync, gulp.parallel(compileHtml, compileSass, compileJs, images), watchFiles);
