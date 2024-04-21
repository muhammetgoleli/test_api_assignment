# API Çalışması

Bu projede, /auth endpoint'i request geldiğinde data, sisteme daha önce kayıtlı değilse create ediyor ve cevap olarak config ve abonelik durumu dönüyor.  

- Proje, Laravel Sail ortamında geliştirildi 

- Veritabanı olarak MySQL kullanıldı.

- Laravel Sanctum, kimlik doğrulama sistemi kullanıldı.

- Veritabanı işlemleri için Eloquent ORM kullanıldı.

- Database migration ve Request validation kullanıldı.

- Listeleme için Yajra Datatables kullanıldı.

- Solid Prensiplerine uygun kodlandı.

- PSR-12 standartlarına, Type Declaration, Syntax, Kod Bütünlüğü ve Okunaklılığa dikkat edildi. 



## Kullanım

Proje, API endpoint'leri üzerinden çalışır ve kullanımı şu şekildedir:

- `/auth`: Cihaz her açıldığında kullanıcının abonelik durumunu ve varsa temel cihaz yapılandırma bilgilerini döndürür

- `/subscription`: Satın alma işleminden sonra abonelik bilgilerini döndürür. Satın alma işleminin hangi cihazdan yapıldığı tespit edilir.

- `/chat`: Kullanıcının abonelik ve kredi kontrolü yapıldıktan sonra ChatGPT botundan response döndürür.

- `/admin/subscriptions`: Kullanıcı abonelik bilgilerinin admin panelinde gösterilmesini sağlar. 

