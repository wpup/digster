<!doctype html>
<html <?php if ( function_exists( 'language_attributes' ) && function_exists( 'is_rtl' ) ) language_attributes(); else echo "dir='$text_direction'"; ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <?php wp_no_robots(); ?>
    <title><?php echo $title ?></title>
    <style>
        html {
          background: #f1f1f1;
        }

        body {
          background: #fff;
          color: #444;
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;
          margin: 50px auto;
          padding: 10px 50px 30px;
          max-width: 700px;
          -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
        }

        div {
          background-color: #fff;
        }

        h1 {
          border-bottom: 1px solid #dadada;
          clear: both;
          color: #666;
          font-size: 24px;
          margin: 30px -0px;
          padding: 0;
          padding-bottom: 7px;
        }

        h2 {
          margin: -20px 0 20px 0;
          font-size: 14px;
          line-height: 1.3;
          font-family: monospace, monospace;
          color: #909090;
          word-break: break-all;
        }

        p {
          margin: 10px 0;
        }

        pre {
          background: black;
          color: #999;
          font-size: 14px;
          padding: 20px;
          white-space: pre-wrap;
          -webkit-tab-size: 4;
          -moz-tab-size: 4;
          tab-size: 4;
        }

        pre code {
          display: block;
          font-family: Consolas, Monaco, monospace;
        }

        pre mark {
          color: white;
          background: none;
        }

        [data-line] {
          display: inline-block;
          box-sizing: border-box;
          width: 100%;
          padding-left: 6ch;
        }

        [data-line]::before {
          content: attr(data-line);
          display: inline-block;
          box-sizing: border-box;
          width: 5ch;
          margin-left: -7ch;
          padding-right: 2ch;
          text-align: right;
          opacity: .6;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }

        mark[data-line]::before {
          opacity: .75;
        }
    </style>
</head>
<body>
    <div>
        <h1><?php echo $title ?></h1>
        <?php
            if ( ! empty( $file ) ) {
                echo sprintf( '<h2>%s</h2>', $file );
            }

            if ( ! empty( $message ) ) {
                echo sprintf( '<p>%s</p>', $message );
            }
        ?>
    </div>
    <?php
        if ( ! empty( $code ) ) {
            echo sprintf( '<pre><code>%s</code></pre>', $code );
        }
    ?>
</body>
</html>
