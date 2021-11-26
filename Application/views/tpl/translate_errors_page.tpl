<html lang="en">
<head>
    <title>Translate Error Messages</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
<section id="translatoreditor">
    <v-app>
        <v-app-bar app>
            <h1>Translate error messages</h1>
        </v-app-bar>

        <v-main>
            <translate-editor :lang_strings='[{$lang_strings}]' langId='[{$langIdToTranslate}]'></translate-editor>
        </v-main>

        <v-footer app>
            <v-row no-gutters justify="end">
                    <v-btn outlined small onclick="window.close()">
                        Close Windows
                    </v-btn>
            </v-row>
        </v-footer>
    </v-app>
</section>
<script src="[{$oViewConf->getModuleUrl("tmInlineTranslator", "out/dist/tmTranslateErrorEditor.js")}]?v1.1"></script>
</body>
</html>
