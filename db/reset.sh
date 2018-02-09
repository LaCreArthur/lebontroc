sqlplus -s ascheidel/ascheidel << EOF
whenever sqlerror sql.sqlcode;
set echo off
set heading off
@run.sql

exit;
EOF
