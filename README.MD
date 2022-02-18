# Projekt: Pizza API 

Du bekommst Anforderungen an eine API, mit der ein Online Pizzashop abgebildet werden soll. Mit Hilfe dieser Anforderungen und einem Mockup für eine Mobile Applikation sollst Du nun eine API mithilfe des PHP-Frameworks entwickeln, welches du zuvor erstellt hast. Überlege dir anhand des Mockups selbst, welche Felder die jeweiligen Models implementieren sollten. 

 

## Ressourcen: 

XD Datei & Anforderungen 

 

## Anforderungen: 

Im Folgenden werden verschiedene Routen aufgelistet, welche deine API anbieten sollte. 

\[POST]: /register 

-> Zum Registrieren eines Nutzers mit {name, email, phone, password} 

\[POST]: /login

-> Zum Einloggen eines Nutzers mit {email, password} 

\[GET]: /products 

-> Array mit Produkten {id, name, category, image_path, sizes: [{ id, name, price }]} 

\[GET]: /categories 

-> Array mit Kategorien (id, name) 

\[POST]: /order 

-> Array mit der Auswahl {product_id, size_id, amount} 

\[GET]: /orders  

-> Array mit allen bereits getätigten Bestellungen 

\[GET, PUT]: /profile 

-> Informationen des aktuell eingeloggten Nutzers  {name, email, phone, password} 