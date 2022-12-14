set LOC=C:\Users\hp\Desktop\Project\DataBase
set SERV=-S HP-PC\SQLEXPRESS -U sa -P RanaJaafar

echo Beginning...

osql %SERV% -i%LOC%\sql\Shop-CreateDB.sql -o%LOC%\log\DB.log
echo Database created...

osql %SERV% -i%LOC%\sql\Shop-CreateTables.sql -o%LOC%\log\Tables.log
echo Tables created...

osql %SERV% -i%LOC%\sql\Shop-CreateIndexes.sql -o%LOC%\log\Indexes.log
echo Indexes created...

osql %SERV% -i%LOC%\sql\Shop-CreateViews.sql -o%LOC%\log\Views.log
echo Views created...

osql %SERV% -i%LOC%\sql\Shop-CreateProcedures.sql -o%LOC%\log\Procedures.log
echo Procedures created...

osql %SERV% -i%LOC%\sql\Shop-CreateTriggers.sql -o%LOC%\log\Triggers.log
echo Triggers created...

osql %SERV% -i%LOC%\sql\Shop-CreateFunctions.sql -o%LOC%\log\Functions.log
echo Functions created...

osql %SERV% -i%LOC%\sql\Shop-InsertData.sql -o%LOC%\log\Data.log
echo Data inserted...

osql %SERV% -i%LOC%\sql\Shop-CreateLogins.sql -o%LOC%\log\Logins.log
echo Logins created...

echo End of batch file...
