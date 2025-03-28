<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Install and run the project follow these steps:

run in console:

git clone git@github.com:sashokrist/-_-.git

open the folder where the project is cloned

composer install

cp .env.example .env

php artisan key:generate

Set database credentials in .env

php artisan migrate and php artisan db:seed or run database/database.sql

npm install

npm run dev

php artisan serve

****************************************************************************

MODELS:

Предоставеният код дефинира няколко модела на Eloquent в приложение на Laravel, основно фокусирани върху управление на резервации, бизнеси и свързани лица. Ето кратко описание на всеки модел и неговото предназначение:

Bookings
   Цел: Управлява записи за резервации за различни услуги (напр. лекари, фризьори, маси).

Ключови характеристики:

Атрибути: Включва полета като user_id, business_id, date_time, client_name, personal_id и идентификатори, специфични за доставчика (doctor_id, hairstylist_id, table_id).

Динамично присвояване на доставчик: Методът createBooking динамично присвоява правилния идентификатор на доставчик въз основа на provider_type.

Филтриране: Методът scopeFilter позволява филтриране на резервации по business_type_id, business_id, personal_id и диапазони от дати.

Взаимоотношения: Принадлежи към бизнес, докторски, фризьорски и настолни модели.

Предстоящи резервации: Методът getUpcomingBookings извлича бъдещи резервации за конкретен клиент, с изключение на даден идентификатор на резервация.

Business
   Цел: Представлява фирми, които предлагат услуги (напр. клиники, салони, ресторанти).

Ключови характеристики:

Атрибути: Включва полета като име, business_type_id, местоположение, телефон и имейл.

Взаимоотношения:

Принадлежи към BusinessType.

Има много фризьорски, масови и докторски модели.

Принадлежи на потребител (собственик).

BusinessType
   Цел: Категоризира бизнесите по типове (напр. медицински, салон, ресторант).

Ключови характеристики:

Атрибути: Попълва се само име.

Връзки: Има много бизнес модели.

Doctor
   Цел: Представлява лекари, свързани с медицинския бизнес.

Ключови характеристики:

Атрибути: Включва име и специализация.

Методи: Осигурява статичен метод getAllDoctors за извличане на всички лекари.

HairStylist
   Цел: Представлява фризьори, свързани с фризьорски салони.

Ключови характеристики:

Атрибути: Включва име, специализация и business_id.

Връзки: Принадлежи към бизнес.

Table
   Предназначение: Представлява маси, свързани с ресторанти.

Ключови характеристики:

Атрибути: Включва номер, места и business_id.

Връзки: Принадлежи към бизнес.

Тези модели формират ядрото на система за резервации за фирми, предлагащи услуги като медицински прегледи, прически и резервации в ресторанти. Моделът за резервация е централен, свързвайки потребители, фирми и доставчици на услуги (лекари, фризьори, маси). Бизнес моделът категоризира фирмите по тип и управлява взаимоотношенията с доставчиците на услуги. Системата е проектирана да бъде гъвкава, позволяваща динамично назначаване на доставчици и филтриране на резервации по различни критерии.

**************************************************************************

CONTROLLERS

BookingController е отговорен за управлението на свързаните с резервацията действия в уеб приложение. Той взаимодейства с BookingService, за да управлява бизнес логиката и предоставя методи за показване, създаване, редактиране, актуализиране и изтриване на резервации. Основните характеристики включват:

Инжектиране на зависимости: Контролерът използва инжектиране на зависимости за достъп до BookingService за обработка на резервационни операции.

index: Индексният метод извлича и показва странициран списък с резервации, заедно с типовете бизнес и бизнеси, като използва метода getAllWithFilters от BookingService.

create: Методът за създаване подготвя данни за създаване на резервация въз основа на типа бизнес (напр. лекари за медицински предприятия, фризьори за салони или маси за ресторанти).

store: Методът на магазина управлява създаването на резервация, улавянето на грешки при валидиране и регистриране на изключения за обработка на грешки.

edit: Методът за редактиране зарежда подробности за резервацията и подготвя данни за редактиране, динамично коригирайки въз основа на типа бизнес.

update: Методът за актуализиране актуализира съществуваща резервация, като обработва грешки и изключения при валидиране и уведомява клиента за промените.

show: Методът показване показва подробна информация за резервация, включително предстоящи резервации за същия клиент.

destroy: Методът за унищожаване изтрива резервация и пренасочва със съобщение за успех.

Този контролер осигурява чисто разделяне на проблемите, като делегира бизнес логиката на BookingService, докато обработва HTTP заявки, валидиране и рендиране на изгледи. Той също така включва стабилно обработване на грешки и регистриране за надеждност.

******************************************************************************************************

BookingController е API контролер който обработва CRUD операции за резервации в система, поддържаща бизнеси като лекари, фризьорски салони и ресторанти. Той използва Sanctum за удостоверяване и предоставя следните ключови функции:

index: Извлича пагиниран списък с резервации с незадължително филтриране. Той включва свързани данни като фирми, видове бизнес, лекари, фризьори и таблици. Грешките се регистрират и се връща JSON отговор.

Store: Потвърждава и създава нова резервация. Той динамично насочва резервацията към правилния доставчик на услуги (лекар, фризьор или маса) въз основа на типа бизнес. Известията се изпращат до бизнеса чрез NotificationService. Връща JSON отговор със създадената резервация или грешка.

show: Извлича и връща подробна информация за конкретна резервация, включително свързани данни за бизнес и доставчик на услуги. Грешките се регистрират и обработват с JSON отговори.

update: Потвърждава и актуализира съществуваща резервация. Той динамично коригира подробностите за резервацията въз основа на типа доставчик (лекар, фризьорски салон или ресторант). Връща JSON отговор с актуализираната резервация или грешка.

destroy: Изтрива резервация и връща съобщение за успех или грешка във формат JSON.

Този controller е проектиран за използване на API, като осигурява правилно обработване на грешки, регистриране и JSON отговори за интегриране с интерфейс или външни системи. Той поддържа множество видове бизнес и включва функция за уведомяване за резервации.

*****************************************************************************************

AuthController е API контролер, който обработва удостоверяването на потребителя, включително регистрация, влизане и излизане. Той използва вградените функции на Laravel като валидиране, удостоверяване на базата на токени и хеширане на пароли. Основните характеристики включват:

Регистрация на потребител: Методът за регистриране валидира въведеното от потребителя (име, имейл, парола), създава нов потребител, хешира паролата и генерира API токен за удостоверяване. Той връща JSON отговор с токена и потребителските данни.

Вход на потребител: Методът за влизане валидира идентификационните данни (имейл и парола), проверява дали потребителят съществува и паролата съвпада и генерира API токен при успешно удостоверяване. Той връща JSON отговор с токена и потребителските данни.

Изход на потребителя: Методът за излизане изтрива всички токени, свързани с удостоверения потребител, като ефективно ги излиза. Той връща JSON отговор, потвърждаващ успешно излизане.

Обработка на грешки: Контролерът използва системата за валидиране на Laravel, за да обработва грешки при въвеждане и предоставя ясни съобщения за грешка (напр. за невалидни идентификационни данни за влизане).

Този контролер осигурява лесен и сигурен начин за управление на удостоверяването на потребителите в контекст на API, като използва Laravel's Sanctum за удостоверяване, базирано на токени.

*****************************************************************************************

BLADES

index.Blade е изглед за управление на резервации в приложение на Laravel. Той предоставя потребителски интерфейс за създаване, филтриране, преглед и управление на резервации. Ето кратко описание на основните му характеристики:

Създайте раздел за резервация:

Показва бутони за създаване на резервации за различни фирми, ако потребителят е удостоверен.

Показва предупреждение и подканва за влизане, ако потребителят не е удостоверен.

Филтърна форма:

Позволява на потребителите да филтрират резервации по:

Тип бизнес (напр. лекар, фризьорски салон, ресторант).

Конкретен бизнес.

Период от време (от/до).

ЕГН.

Изпраща филтрите към route bookings.index.

Таблица за резервации:

Показва списък с резервации с колони за:

Дата и час.

Име на клиента.

ЕГН.

Име на фирмата.

Доставчик на услуги (лекар, фризьор или маса, в зависимост от вида на бизнеса).

Метод на уведомяване (SMS или имейл).

Бутони за действие (детайли, редактиране, изтриване).

Показва „N/A“ за липсващи или недефинирани данни.

Позволява на удостоверените потребители да редактират или изтриват собствените си резервации.

Странициране:

Използва Странициране в стил Bootstrap за навигация в списъка с резервации.

Динамично съдържание:

Показва подробности за доставчика на услуги динамично въз основа на типа бизнес (напр. име на лекар, име на фризьор или номер на маса).

index.blade е предназначен за удобно за потребителя взаимодействие със системата за резервации, като предоставя възможности за филтриране, преглед и управление, като същевременно осигурява правилен контрол на достъпа за удостоверени потребители.

**********************************************************************************************

create.Blade е за създаване на резервация . Позволява на потребителите да създават нова резервация за конкретен бизнес, като динамично коригират формуляра въз основа на вида бизнес (напр. лекар, фризьорски салон или ресторант). Ето кратко описание на основните му характеристики:

Бизнес избор:

Предварително избира бизнеса, прехвърлен към изгледа, и деактивира промените (тъй като бизнесът вече е избран).

Включва обработка на грешки при невалиден бизнес избор.

Избор на доставчик на услуги:

Динамично показва доставчиците на услуги (лекари, фризьори или маси) въз основа на типа бизнес.

Използва скрит вход (provider_type) за съхраняване на типа бизнес (напр. лекар, фризьорски салон, ресторант).

Полета на формата:

Дата и час: Позволява на потребителите да избират бъдеща дата и час за резервацията.

Име на клиента: Попълва предварително името на удостоверения потребител и го прави само за четене.

Личен идентификатор (EGN): Улавя личния идентификатор на клиента с валидиране.

Описание: Незадължително поле за допълнителни подробности за резервацията.

Метод на уведомяване: Позволява на потребителите да избират между SMS или имейл за известия.

Динамичен JavaScript:

Динамично извлича доставчици на услуги, когато бизнесът е избран.

Актуализира падащото меню за доставчик на услуги въз основа на типа бизнес.

Обработка на грешки:

Показва грешки при валидиране за всяко поле с помощта на директивата @error на Laravel.

Бутон за изпращане:

Изпраща формата към route bookings.store, за да създаде нова резервация.

create.blade е предназначен за удобно за потребителя създаване на резервация, с динамично зареждане на съдържание и стабилно обработване на грешки, за да се осигури гладко изживяване. Той поддържа множество видове бизнес и се интегрира с API за извличане на доставчици на услуги

*************************************************************************************************

edit.Blade е формуляр за редактиране на резервация. Позволява на потребителите да актуализират съществуваща резервация, динамично коригирайки формуляра въз основа на вида бизнес (напр. лекар, фризьорски салон или ресторант). Ето кратко описание на основните му характеристики:

Настройка на формата:

Използва метода PUT, за да изпрати актуализации на маршрута bookings.update.

Включва CSRF защита и скрити полета за provider_type и business_id за осигуряване на правилна обработка.

Дисплей тип бизнес:

Показва типа бизнес (лекар, фризьорски салон или ресторант) въз основа на свързания с резервацията доставчик на услуги (лекар, фризьор или маса).

Полето е деактивирано, за да се предотвратят промени.

Избор на доставчик на услуги:

Динамично зарежда доставчици на услуги (лекари, фризьори или маси) въз основа на типа бизнес.

Предварително избира текущо свързания доставчик на услуги за резервацията.

Полета на формата:

Дата и час: Позволява на потребителите да актуализират датата и часа на резервацията.

Име на клиента: Показва името на клиента като поле само за четене.

Личен идентификатор (EGN): Позволява актуализиране на личния идентификатор на клиента с валидиране.

Описание: Незадължително поле за допълнителни подробности за резервацията.

Метод на уведомяване: Позволява на потребителите да актуализират метода на уведомяване (SMS или имейл).

Обработка на грешки:

Показва грешки при валидиране за всяко поле с помощта на директивата @error на Laravel.

Бутон за изпращане:

Изпраща формуляра за актуализиране на резервацията.

edit.blade предназначен за удобни за потребителя актуализации на резервации, с динамично зареждане на съдържание и стабилно обработване на грешки, за да се осигури гладко изживяване при редактиране. Той поддържа множество видове бизнес и гарантира, че правилният доставчик на услуги е предварително избран за редактиране

*************************************************************************************************

show.Blade е изглед на подробности за резервация. Той показва изчерпателна информация за конкретна резервация и включва допълнителна функционалност за показване на предстоящи резервации за същия клиент. Ето кратко описание на основните му характеристики:

Подробности за резервацията:

Показва важна информация за резервация като:

Име и тип на фирмата.

Дата и час на резервацията.

Име на клиента и ЕГН.

Подробности за доставчика на услуги (лекар, фризьор или маса) въз основа на типа бизнес.

Опционално описание и метод за уведомяване (SMS или имейл).

Динамичен дисплей на доставчика на услуги:

Показва съответния доставчик на услуги (лекар, фризьор или маса) динамично въз основа на типа бизнес.

Секция за предстоящи резервации:

Изброява предстоящи резервации за същия клиент (ако има такива), с изключение на текущата резервация.

Предоставя връзки за преглед на подробности за всяка предстояща резервация.

Навигация:

Включва бутон „Назад“ за връщане към индексната страница на резервациите.

show.blade е предназначен за удобен за потребителя преглед на подробностите за резервацията, с ясно и организирано представяне на информация. Той също така подобрява използваемостта, като показва свързани предстоящи резервации за клиента, което улеснява управлението на множество резервации.

*************************************************************************************************
INTERFACES, SERVICES, CONTROLLERS, ROUTES

За да поддържаме всичко чисто и лесно за управление, разделяме логиката на 3 основни слоя:

🧩 1. Interfaces 
Пишем интерфейси, за да дефинираме какво трябва да се направи (като списък, създаване, актуализиране, изтриване), но не и как се прави.

"Всяка услуга трябва да има тези методи."

🔧 2. Services 
Всяки service (като DoctorService, HairstylistService и т.н.) използва този interface и върши истинската работа – комуникира с базата данни.

Тези класове о управляват бизнес логиката.

🎮 3. Controllers
Controllers получават заявката от потребителите (чрез уеб или API), изискват от service да свършат работата и изпращат отговор.

Controllers не правят много сами - те просто казват на services какво да правят.

🔌 4.Routes
Ние дефинираме Routes, така че Laravel да знае:

„Когато потребител посети /лекари, извикайте DoctorController@index()“

Всеки ресурс (лекари, фризьори, таблици) има Routes за списък, показване, създаване, актуализиране и изтриване.

✅ Лесен за управление

✅ Чист, четим код

✅ добавяне на повече функции или типове

Ако някога се наложи да актуализирате как се борави с лекарите, просто актуализирайте DoctorService — не е нужно да докосвате контролера или други части.

*************************************************************************************************

BookingService е PHP service, която обработва операции, свързани с резервации в приложение на Laravel. Той имплементира BookingServiceInterface и предоставя методи за извличане, създаване, актуализиране, преглед и изтриване на резервации. Основните характеристики включват:

Филтрирано извличане: Методът getAllWithFilters извлича резервации с незадължителни филтри, пагинация и сортиране, като същевременно зарежда свързани модели като бизнес, лекар, фризьор и таблица.

Валидиране: Методите createBooking и updateBooking валидират входните данни (напр. business_id, date_time, client_name и т.н.) с помощта на системата за валидиране на Laravel, с персонализирани съобщения за грешка за конкретни полета.

Динамично картографиране на доставчика: Методът updateBooking динамично картографира service_provider_id към съответния тип доставчик (лекар, фризьорски_салон или ресторант) и актуализира съответните полета (doctor_id, hairstylist_id или table_id).

Операции на CRUD: Услугата поддържа създаване, актуализиране, преглед и изтриване на резервации с методи като createBooking, updateBooking, showBooking и destroyBooking.

Интегриране на известия: Въпреки че е коментиран, кодът предлага интегриране с NotificationService за изпращане на известия чрез SMS или имейл, когато се създават или актуализират резервации.

Тази услуга централизира логиката на резервациите, като гарантира съгласуваност на данните и осигурява чист интерфейс за управление на резервациите в приложението.

************************************************************************************
Test API:
POST /api/register

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password"
}

POST /api/login

{
  "email": "test@example.com",
  "password": "password"
}

The response will also contain a token:

{
  "token": "your_sanctum_token_here",
  "user": { ... }
}

GET /api/bookings

Authorization: Bearer your_sanctum_token_here

Accept: application/json

Content-Type: application/json

***********************************************************************************

SCREENSHOTS:
![filter](https://github.com/user-attachments/assets/4f1068b1-7086-4006-ac4f-a8a0452a13c1)
![filter 2](https://github.com/user-attachments/assets/2e0ade76-aa24-4447-b0c3-1eea9f5e39f9)
![edit](https://github.com/user-attachments/assets/59c329c3-70bc-4263-b32d-2ad22a867972)
![detail](https://github.com/user-attachments/assets/6b780c3a-dee9-4aac-b2b1-33abe6890cd0)
![create](https://github.com/user-attachments/assets/e94392ab-7c3d-418e-a566-c7236cbf25a6)
![index](https://github.com/user-attachments/assets/4ec6fdd7-c014-45a6-8f04-d303de15b4ba)
![delete](https://github.com/user-attachments/assets/a92d0d23-40f2-4ec3-a739-e09a87661f34)

API:
![api_login](https://github.com/user-attachments/assets/56453075-39cf-40e8-9d00-ad026c414067)
![api_bookings](https://github.com/user-attachments/assets/1efb11fa-b94f-4443-893b-64bd4d4c03fc)
![api_reg](https://github.com/user-attachments/assets/5eab171f-03c1-4909-a23e-d615c0578248)



