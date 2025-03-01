### Предварительные требования

* PHP ^8.2
* Make
* Composer
* Docker
* Node.js & NPM

### Запуск с разворачиванием в Docker-контейнере

1. Установить зависимости
    ```sh
    make install
    ```

2. Подготовить конфигурационный файл
     ```sh
    make prepare-env
    ```

3. Добавить json-файл учетной записи для сервиса Google. Путь к нему прописать на следующем шаге (GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION)


4. Настроить параметры в .env 
    ```dotenv
    DB_USERNAME=your_user
    DB_PASSWORD=your_password
    ```
    ```dotenv
    GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION=
    GOOGLE_CLIENT_ID=
    GOOGLE_CLIENT_SECRET=
    ```


5. Запуск контейнеров
    ```sh
    make up
    ```

6. Миграция
    ```sh
    make mig
    ```
