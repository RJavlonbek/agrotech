export default {
  'It should have select elements for each media device': (browser) => {
    const path = '/src/content/devices/input-output/index.html';
    const url = 'file://' + process.cwd() + path;

    // audio output is't supported on Safari or Firefox
    const browserName = browser.options.desiredCapabilities.browserName;
    if (browserName === 'firefox' || browserName === 'safari') {
      browser
        .url(url)
        .waitForElementVisible('#videoSource option:nth-of-type(1)', 1000, 'Check that there is at least one video source')
        .end();
      return;
    }

    browser
      .url(url)
      .waitForElementVisible('#videoSource option:nth-of-type(1)', 1000, 'Check that there is at least one video source')
      .end();
  }
};