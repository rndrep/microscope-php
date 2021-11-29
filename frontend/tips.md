# npm

-   Create a package.json file
    `npm init`

-   npm install по умолчанию сохраняет все указанные пакеты в dependencies.
    `npm install`

-   Кроме того, вы можете контролировать, где и как они сохраняются, с помощью некоторых дополнительных флагов:\
    -P, --save-prod: Пакет появится в вашем dependencies. Это значение по умолчанию, если не присутствуют -D или -O.\
    -D, --save-dev: Пакет появится в вашем devDependencies.\
    -O, --save-optional: Пакет появится в вашем optionalDependencies.\
    --no-save: Предотвращает сохранение в dependencies.

-   удаление пакета
    `npm uninstall <package_name>`

-   Если вы установили пакет как devDependency (т.е. с --save-dev), используйте --save-dev для его удаления:
    `npm uninstall --save-dev <package_name>`

# установка webpack и webpack-cli

```
mkdir webpack-demo
cd webpack-demo
npm init -y
npm install webpack webpack-cli --save-dev
```

-   запуск webpack

```
npx webpack
```

# webpack.config

-   development быстрее, потом изменить на production (сжимает и оптимизирует код)

```
mode: "development" / "production"
```

-   установка модулей вебпака

npm install --save file-loader url-loader

-   development быстрее, потом изменить на production (сжимает и оптимизирует код)
-   вебпак конфиг можно настроить в гальп и добавить webpack-stream как таск

```
let microDeg = document.querySelector(".degrees");
microDeg.textContent = `0°` || `${Math.round(rotation)}`;
```

-   компиляция вебпак микс

```
npm run dev
```
