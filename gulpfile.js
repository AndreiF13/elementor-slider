const { src, dest, series, task } = require("gulp");
const wpPot = require("gulp-wp-pot");
const sort = require("gulp-sort");
const notify = require("gulp-notify");

const translate = async () => {
  const translateFiles = "./**/*.php";
  const textDomain = "elementor-slider";
  const destFile = "elementor-slider.pot";
  const packageName = "elementor-slider";
  const bugReport = "https://github.com/andreif13/elementor-slider/issues/";
  const lastTranslator = "Andrei F. <andrei@webdesignwordpress.eu>";
  const team = "Andrei F. <andrei@webdesignwordpress.eu>";
  const translatePath = "./languages/";

  return await src(translateFiles)
    .pipe(sort())
    .pipe(
      wpPot({
        domain: textDomain,
        destFile: destFile,
        package: packageName,
        bugReport: bugReport,
        lastTranslator: lastTranslator,
        team: team,
      })
    )
    .pipe(dest(translatePath + "/" + destFile))
    .pipe(notify({ message: "SUCCESS: Pot file generated!", onLast: true }));
};

task("translate", series(translate));
