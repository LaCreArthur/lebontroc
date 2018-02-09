


function ref_cursor_to_json (p_ref_cursor in sys_refcursor,
p_max_rows in number := null,
p_skip_rows in number := null) return clob
as
l_ctx         dbms_xmlgen.ctxhandle;
l_num_rows    pls_integer;
l_xml         xmltype;
l_json        xmltype;
l_returnvalue clob;
begin

/*

Purpose:    generate JSON from REF Cursor
Remarks:
Who     Date        Description
------  ----------  -------------------------------------
MBR     30.01.2010  Created
*/

l_ctx := dbms_xmlgen.newcontext (p_ref_cursor);

dbms_xmlgen.setnullhandling (l_ctx, dbms_xmlgen.empty_tag);

-- for pagination
if p_max_rows is not null then
dbms_xmlgen.setmaxrows (l_ctx, p_max_rows);
end if;

if p_skip_rows is not null then
dbms_xmlgen.setskiprows (l_ctx, p_skip_rows);
end if;

-- get the XML content
l_xml := dbms_xmlgen.getxmltype (l_ctx, dbms_xmlgen.none);

l_num_rows := dbms_xmlgen.getnumrowsprocessed (l_ctx);

dbms_xmlgen.closecontext (l_ctx);

close p_ref_cursor;

if l_num_rows > 0 then
-- perform the XSL transformation
l_json := l_xml.transform (xmltype(get_xml_to_json_stylesheet));
l_returnvalue := l_json.getclobval();
else
l_returnvalue := g_json_null_object;
end if;

l_returnvalue := dbms_xmlgen.convert (l_returnvalue, dbms_xmlgen.entity_decode);

return l_returnvalue;

end ref_cursor_to_json;
