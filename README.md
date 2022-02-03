# app-xampp

Projekt web CRUD symulujący listę kontaktów w phpie podłączone do MysQL. Dodatkowo jest możliwość administracji bazą danych przy użyciu phpMyAdmin.

## Instalacja

Potrzeba instalacja [dockera](https://www.docker.com/products/docker-desktop).
Aby zainstalować aplikację ściągnąć archiwum z githuba, przejść do folderu i odpalić

```bash
docker-compose up
```

ważne, aby przy instalacji an Windowsie wykorzystać PowerShella, jako że inicjalizacja MySQL odbywa się na wydzielonym folderze lokalnym podczas której zmieniani są właściciele plików. Przy użyciu WSL możliwość zapętlenia się startu wymagająca zatrzymania i usunięcia utworzonego folderu "db".
Jeśli użytkownik nie chciałby inicjalizować MySQL na swojej maszynie trzeba usunąć linijkę kody z dockercompose.yml:

```yml
volumes:
  - ./db:/var/lib/mysql
```

## Wykorzystanie

Aby połączyć się ze stroną głowną należy wejść na adres [localhost:8000](http://localhost:8000/)

Aby połączyć się z phpMyAdmin należy wejść na adres [localhost:8080](http://localhost:8000/)

Po wejściu na stronę główną można przejść do kontaktów gdzie jest możliwość tworzenia, edycji i usuwania kontaktów z bazy danych.
Jeśli użytkownik chciałby importować jeszcze jakąś bazę danych, lub importować zmienioną werjse bazy danych trzeba wrzucić plik .sql do folderu mysql.
