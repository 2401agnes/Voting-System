<?php
@session_start();
$_SESSION["SkipConnectMySQL"] = "";
require('qs_connection.php');
require('qs_functions.php');
$err_string="";
$quotechar = "`";
$quotedate = "'";
$sql = "";
$sql_ext = "";
$SQL_GroupOnly = "";
$sqlmaster = "";
$sql_extmaster = "";
$cellvalue = "";
$istrdata = "";
$icon = "";
$ioldcon = "";
$sortstring = "";
$parammaster = array();
$fields = array();
$intColCount = 0;
$intColIndex = 0;
$fields[0] = "candidate.`id`";
$parammaster[0] = "";
$fields[1] = "candidate.`position`";
$parammaster[1] = "";
$fields[2] = "candidate.`name`";
$parammaster[2] = "";
$fields[3] = "candidate.`platform`";
$parammaster[3] = "";
$fields[4] = "candidate.`picture`";
$parammaster[4] = "";
$fields[5] = "candidate.`votecount`";
$parammaster[5] = "";
$fields[6] = "candidate.`sy`";
$parammaster[6] = "";
$sql .= " Select\n";
$sql .= "     candidate.`id`,\n";
$sql .= "     candidate.`position`,\n";
$sql .= "     candidate.`name`,\n";
$sql .= "     candidate.`platform`,\n";
$sql .= "     candidate.`picture`,\n";
$sql .= "     candidate.`votecount`,\n";
$sql .= "     candidate.`sy`\n";
$sql .= " From\n";
$sql .= "     candidate   candidate\n";


$searchmode = array();
$stdsearchopt = array();
$searchmode[0] = 0;
$stdsearchopt[0]=0;
$searchmode[1] = 0;
$stdsearchopt[1]=1;
$searchmode[2] = 0;
$stdsearchopt[2]=0;
$searchmode[3] = 0;
$stdsearchopt[3]=0;
$searchmode[4] = 0;
$stdsearchopt[4]=0;
$searchmode[5] = 0;
$stdsearchopt[5]=0;
$searchmode[6] = 0;
$stdsearchopt[6]=0;
$rs_idx_id           = 0;
$rs_idx_position     = 1;
$rs_idx_name         = 2;
$rs_idx_platform     = 3;
$rs_idx_picture      = 4;
$rs_idx_votecount    = 5;
$rs_idx_sy           = 6;

if (strpos(strtoupper($sql), " WHERE ")) {
    $sqltemp = $sql . " AND (1=0) ";
}else{
    $sqltemp = $sql . " Where (1=0) ";
}
if(!$result = @mysql_query($sqltemp . " " . $sql_ext . " limit 0,1")){
    $err_string .= "<strong>Error:</strong>while connecting to database<br>" . mysql_error();
}
if ($err_string != "") {
    print "<Center><Table Border=\"0\" Cellspacing=\"1\" bgcolor=\"#CCCCCC\" >";
    print "<tr>";
    print "<td height=\"80\" align=\"Default\" bgcolor=\"#FFFFFF\">";
    print "<font color=\"#000099\" size=\"2\">";
    print $err_string;
    print "</font>";
    print "</td>";
    print "</tr>";
    print "</Table></Center>";
    exit;
} //==end if $err_string != ""
if (qsrequest("clearsession") == "1") {
    $_SESSION["tally_tally"] = "";
    $_SESSION["tally_tally_PageNumber"] = "";
} //==end if clearsession$filter_string = "";
$filter_stringmaster = "";
$qry_string = "";
$i = 0;
$searchendkey ="";
$searchstartkey = "";
while ($i < mysql_num_fields($result)) {
    $meta = mysql_fetch_field($result);
    $field_name  = $meta->name;
    $field_table = $meta->table;
    $field_type  = $meta->type;
    $type_field = "";
    $type_field = returntype($field_type);
    if (($searchmode[$i])==0) { # 0 = Std, 1 = Advance
        if (($stdsearchopt[$i])==0) { //==0=Contain , 1 = Equal : for standard mode
            $searchstartkey = "%";
            $searchendkey = "%";
        } else {
            $searchstartkey = "";
            $searchendkey = "";
        }
    } else { //==end if searchmode = 0
        $searchstartkey= "";
        $searchendkey = "";
    } //==end if searchmode <> 0
    if (qsrequest("clearsession") == "1") {
        $_SESSION["tally_search_fd" . $i] = "";
        $_SESSION["tally_multisearch_fd" . $i] = "";
        $_SESSION["tally_search_fd_" . $i] = "";
        $_SESSION["tally_search_fd" . $i . "_DateFormat"] = "";
        $_SESSION["tally_search_fd_" . $i . "_DateFormat"] = "";
    } //==end if clearsession
    if (qsrequest("search_fd" . $i) != "") {
        $_SESSION["tally_search_fd" . $i] = qsrequest("search_fd" . $i);
    }
    if (qsrequest("multisearch_fd" . $i) != "") {
        $_SESSION["tally_multisearch_fd" . $i] = qsrequest("multisearch_fd" . $i);
    }
    if (qsrequest("search_fd_" . $i) != "") {
        $_SESSION["tally_search_fd_" . $i] = qsrequest("search_fd_" . $i);
    }
    //Prepare date format of each item search to Session
    if (qsrequest("search_fd" . $i . "_DateFormat") != "") {
        $_SESSION["tally_search_fd" . $i . "_DateFormat"] = qsrequest("search_fd" . $i . "_DateFormat");
    }
    if (qsrequest("search_fd_" . $i . "_DateFormat") != "") {
        $_SESSION["tally_search_fd_" . $i . "_DateFormat"] = qsrequest("search_fd_" . $i . "_DateFormat");
    }
    if ((qssession("tally_search_fd" . $i) != "") && (qssession("tally_search_fd" . $i) != "*")) {
        $idata = qssession("tally_search_fd" . $i);
        $icon = " AND ";
        $ioldcon = "";
        if (substr($idata, 0, 2) == "||") {
            $icon = " Or ";
            $ioldcon = "||";
            $iopt = substr($idata, 2, 2);
            $idata = substr($idata, 2);
        }else{
            $iopt = substr($idata, 0, 2);
        }
        $idata = str_replace("*", "%", $idata);
        $irealdata = $idata;
        $iopt = substr($idata, 0, 2);
        if (($iopt == "<=") || ($iopt == "=<")) {
            $iopt = "<=";
            $irealdata = substr($idata, 2);
        } elseif (($iopt == ">=") || ($iopt == "=>")) {
            $iopt = ">=";
            $irealdata = substr($idata, 2);
        } elseif ($iopt == "==") {
            $iopt = "=";
            $irealdata = substr($idata, 2);
        } elseif ($iopt == "<>") {
            $irealdata = substr($idata, 2);
        } else {
            $iopt = substr($idata, 0, 1);
            if (($iopt == "<") || ($iopt == ">") || ($iopt == "=")) {
                $irealdata = substr($idata,1);
            } else {
                $iopt = "=";
            }
        }
        if (!strcasecmp($idata,"{current date and time}")) {
            $idata = time();
        } elseif (!strcasecmp($idata,"{current date}")) {
            $idata = time();
        } elseif (!strcasecmp($idata,"{current time}")) {
            $idata = time();
        }
        if ($meta) {
            if ($type_field == "type_datetime") {
                if ((($timestamp = strtotime($irealdata)) !== -1)) {
                    if (($iopt)=="="){
                        $conditionstr = " = ";
                        $istrdata = str_replace("=", "", $istrdata);
                    } else {
                        $conditionstr = $iopt;
                        $istrdata = $irealdata;
                        $searchstartkey = "";
                        $searchendkey   = "";
                    }
                    //Prepare  date format for each item search then convert to compatible format
                    if (qssession("tally_search_fd" . $i . "_DateFormat") != ""){
                        $iDateFormat = qssession("tally_search_fd" . $i . "_DateFormat");
                    } else {
                        $iDateFormat = "";
                    }
                    if ((qssession("tally_multisearch_fd" . $i) != "")) {
                        $multisearch = qssession("tally_multisearch_fd" . $i);
                        $searcharray = split(",",$multisearch);
                        if ($qry_string == "") {
                            $qry_string = "search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                            $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                            $filter_string = "(" . $fields[$i] . $conditionstr . " ". $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            $j = 0;
                            for ($j = 0; $j < count($searcharray); $j++) {
                                $searchindex = $searcharray[$j];
                                $filter_string .= " OR " . $fields[$searchindex]  . $conditionstr . " ". $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            }
                            $filter_string .= ")";
                        } else {
                            $qry_string .= "&search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                            $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                            $filter_string .= " AND (" . $fields[$i]  . $conditionstr . " " . $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            $j = 0;
                            for ($j = 0; $j < count($searcharray); $j++) {
                                $searchindex = $searcharray[$j];
                                $filter_string .= " OR " . $fields[$searchindex]  . $conditionstr . " " . $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            }
                            $filter_string .= ")";
                        }
                    } else {
                        if ($qry_string == "") {
                            $qry_string = "search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                            $filter_string = $fields[$i]  . $conditionstr . " " . $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            if ($parammaster[$i] != ""){
                                $filter_stringmaster = $parammaster[$i]  . $conditionstr . " " . $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            }
                        } else {
                            $qry_string .= "&search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                            $filter_string .= $icon . $fields[$i]  . $conditionstr . " " . $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            if ($parammaster[$i] != ""){
                                $filter_stringmaster .= $icon . $parammaster[$i]  . $conditionstr . " " . $quotedate . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $quotedate;
                            }
                        }
                    }
                } else {
                    $err_string .= "<strong>Error:</strong>while searching.<strong>" . $field_name . "</strong>.<br>";
                    $err_string .= "Description: Invalid DateTime.<br>";
                }
                //==end $type_field == "type_datetime"
            } elseif ($type_field == "type_integer") {
                $irealdata = str_replace("%", "", $irealdata);
                if (is_numeric($irealdata)) {
                    if ((qssession("tally_multisearch_fd" . $i) != "")) {
                        $multisearch = qssession("tally_multisearch_fd" . $i);
                        $searcharray = split(",",$multisearch);
                        if ($qry_string == "") {
                            $qry_string = "search_fd" . $i . "=" . $ioldcon . $idata;
                            $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                            $filter_string = "(" . $fields[$i] . " " . $iopt . " " . $irealdata;
                            $j = 0;
                            for ($j = 0; $j < count($searcharray); $j++) {
                                $searchindex = $searcharray[$j];
                                $filter_string .= " OR " . $fields[$searchindex] . " " . $iopt . " " . $irealdata;
                            }
                            $filter_string .= ")";
                        } else {
                            $qry_string .= "&search_fd" . $i . "=" . $ioldcon . $idata;
                            $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                            $filter_string .= " AND (" . $fields[$i] . " " . $iopt . " " . $irealdata;
                            $j = 0;
                            for ($j = 0; $j < count($searcharray); $j++) {
                                $searchindex = $searcharray[$j];
                                $filter_string .= " OR " . $fields[$searchindex] . " " . $iopt . " " . $irealdata;
                            }
                            $filter_string .= ")";
                        }
                    } else {
                        if ($qry_string == "") {
                            $qry_string = "search_fd" . $i . "=" . $ioldcon . $idata;
                            $filter_string = $fields[$i] . " " . $iopt . " " . $irealdata;
                            if ($parammaster[$i] != ""){
                                $filter_stringmaster = $parammaster[$i] . " " . $iopt . " " . $irealdata;
                            }
                        } else {
                            $qry_string .= "&search_fd" . $i . "=" . $ioldcon . $idata;
                            $filter_string .= $icon . $fields[$i] . " " . $iopt . " " . $irealdata;
                            if ($parammaster[$i] != ""){
                                $filter_stringmaster .= $icon . $parammaster[$i] . " " . $iopt . " " . $irealdata;
                            }
                        }
                    }
                } else {
                    $err_string .= "<strong>Error:</strong>while searching.<strong>" . $field_name . "</strong>.<br>";
                    $err_string .= "Description: Type mismatch.<br>";
                }
                //==end $type_field == "type_integer"
            } elseif ($type_field == "type_string") {
                if (($iopt)=="="){
                    $conditionstr = " Like ";
                    $istrdata = str_replace("=", "", $istrdata);
                } else {
                    $conditionstr = $iopt;
                    $istrdata = $irealdata;
                    $searchstartkey = "";
                    $searchendkey   = "";
                }
                if ((qssession("tally_multisearch_fd" . $i) != "")) {
                    $multisearch = qssession("tally_multisearch_fd" . $i);
                    $searcharray = split(",",$multisearch);
                    if ($qry_string == "") {
                        $qry_string = "search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                        $filter_string = "(" . $fields[$i] . $conditionstr . " '" .$searchstartkey.  ereg_replace("'","''",stripslashes($irealdata)). $searchendkey . "'";
                        $j = 0;
                        for ($j = 0; $j < count($searcharray); $j++) {
                            $searchindex = $searcharray[$j];
                            $filter_string .= " OR " . $fields[$searchindex]  . $conditionstr . " '" .$searchstartkey.  ereg_replace("'","''",stripslashes($irealdata)). $searchendkey . "'";
                        }
                        $filter_string .= ")";
                    } else {
                        $qry_string .= "&search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                        $filter_string .= " AND (" . $fields[$i]  . $conditionstr . " '" .$searchstartkey. ereg_replace("'","''",stripslashes($irealdata)) . $searchendkey . "'";
                        $j = 0;
                        for ($j = 0; $j < count($searcharray); $j++) {
                            $searchindex = $searcharray[$j];
                            $filter_string .= " OR " . $fields[$searchindex]  . $conditionstr . " '" .$searchstartkey. ereg_replace("'","''",stripslashes($irealdata)) . $searchendkey . "'";
                        }
                        $filter_string .= ")";
                    }
                } else {
                    if ($qry_string == "") {
                        $qry_string = "search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $filter_string = $fields[$i]  . $conditionstr . " '" .$searchstartkey. ereg_replace("'","''",stripslashes($irealdata)) . $searchendkey . "'";
                        if ($parammaster[$i] != ""){
                            $filter_stringmaster = $parammaster[$i]  . $conditionstr . " '" .$searchstartkey. ereg_replace("'","''",stripslashes($irealdata)) . $searchendkey . "'";
                        }
                    } else {
                        $qry_string .= "&search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $filter_string .= $icon . $fields[$i]  . $conditionstr . " '" .$searchstartkey. ereg_replace("'","''",stripslashes($irealdata)) . $searchendkey . "'";
                        if ($parammaster[$i] != ""){
                            $filter_stringmaster .= $icon . $parammaster[$i]  . $conditionstr . " '" .$searchstartkey. ereg_replace("'","''",stripslashes($irealdata)) . $searchendkey . "'";
                        }
                    }
                }
                //==end $type_field == "type_string"
            } else {
                if ((qssession("tally_multisearch_fd" . $i) != "")) {
                    $multisearch = qssession("tally_multisearch_fd" . $i);
                    $searcharray = split(",",$multisearch);
                    $irealdata = str_replace("%", "",  $irealdata);
                    if ($qry_string == "") {
                        $qry_string = "search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                        $filter_string = "(" . $fields[$i] . " = '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        $j = 0;
                        for ($j = 0; $j < count($searcharray); $j++) {
                            $searchindex = $searcharray[$j];
                            $filter_string .= " OR " . $fields[$searchindex] . " = '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        }
                        $filter_string .= ")";
                    } else {
                        $qry_string .= "&search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $qry_string .= "&multisearch_fd" . $i . "=" . qssession("tally_multisearch_fd" . $i);
                        $filter_string .= " AND (" . $fields[$i] . " = '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        $j = 0;
                        for ($j = 0; $j < count($searcharray); $j++) {
                            $searchindex = $searcharray[$j];
                            $filter_string .= " OR " . $fields[$searchindex] . " = '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        }
                        $filter_string .= ")";
                    }
                } else {
                    if ($qry_string == "") {
                        $qry_string = "search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $filter_string = $fields[$i] . " like '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        if ($parammaster[$i] != ""){
                            $filter_stringmaster = $parammaster[$i] . " like '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        }
                    } else {
                        $qry_string .= "&search_fd" . $i . "=" . $ioldcon . urlencode(stripslashes($idata));
                        $filter_string .= $icon . $fields[$i] . " like '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        if ($parammaster[$i] != ""){
                            $filter_stringmaster .= $icon . $parammaster[$i] . " like '" . ereg_replace("'","''",stripslashes($irealdata)) . "'";
                        }
                    }
                }
            } //==end $type_field == "type_unknown
        } //==end if ($meta)
    } //==end if search_fd(n) <> ""
    //==Begin Search between
    if (qssession("tally_search_fd_" . $i)) {
        $idata = qssession("tally_search_fd_" . $i);
        $idata = str_replace("*", "%", $idata);
        $irealdata = $idata;
        $iopt = substr($idata, 0, 2);
        if (($iopt == "<=") || ($iopt == "=<")) {
            $iopt = "<=";
            $irealdata = substr($idata, 2);
        } elseif (($iopt == ">=") || ($iopt == "=>")) {
            $iopt = ">=";
            $irealdata = substr($idata, 2);
        } elseif ($iopt == "==") {
            $iopt = "=";
            $irealdata = substr($idata, 2);
        } elseif ($iopt == "<>") {
            $irealdata = substr($idata, 2);
        } else {
            $iopt = substr($idata, 0, 1);
            if (($iopt == "<") || ($iopt == ">") || ($iopt == "=")) {
                $irealdata = substr($idata,1);
            } else {
                $iopt = "=";
            }
        }
        if ($meta) {
            if ($type_field == "type_datetime") {
                if ((($timestamp = strtotime($irealdata)) !== -1)) {
                    if (($iopt)=="="){
                        $conditionstr = " = ";
                        $istrdata = str_replace("=", "", $istrdata);
                    } else {
                        $conditionstr = $iopt;
                        $istrdata = $irealdata;
                        $searchstartkey = "";
                        $searchendkey   = "";
                    }
                }
                //Prepare  date format for each item search then convert to compatible format
                if (qssession("tally_search_fd_" . $i . "_DateFormat") != ""){
                    $iDateFormat = qssession("tally_search_fd_" . $i . "_DateFormat");
                } else {
                    $iDateFormat = "";
                }
                if ($qry_string == "") {
                    $qry_string = "search_fd_" . $i . "=" . $iopt . urlencode(stripslashes($irealdata));
                    $filter_string = $fields[$i]  . $conditionstr . " " . $quotedate .$searchstartkey . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $searchendkey . $quotedate;
                } else {
                    $qry_string .= "&search_fd_" . $i . "=" . $iopt . urlencode(stripslashes($irealdata));
                    $filter_string .= " AND " . $fields[$i]  . $conditionstr . " " . $quotedate . $searchstartkey . qsconvertdate2ansi($irealdata, $iDateFormat, "") . $searchendkey . $quotedate;
                }
                //==end $type_field == "type_datetime"
            } elseif ($type_field == "type_integer") {
                $irealdata = str_replace("%", "", $irealdata);
                if (is_numeric($irealdata)) {
                    if ($qry_string == "") {
                        $qry_string = "search_fd_" . $i . "=" . $iopt . $irealdata;
                        $filter_string = $fields[$i] . " " . $iopt . " " . $irealdata;
                    } else {
                        $qry_string .= "&search_fd_" . $i . "=" . $iopt . $irealdata;
                        $filter_string .= " AND " . $fields[$i] . " " . $iopt . " " . $irealdata;
                    }
                } else {
                    $err_string .= "<strong>Error:</strong>while searching.<strong>" . $field_name . "</strong>.<br>";
                    $err_string .= "Description: Type mismatch.<br>";
                }
            } //==end $type_field == "type_integer"
        } //==end if ($meta)
    } //==end if search_fd_(n) <> "" for between search
    $i++;
} //==end while loop field index
if ($result > 0) {mysql_free_result($result);}
if ($filter_string != "") {
    $filter_string = "(" . $filter_string . ")";
    if (strpos(strtoupper($sql), " WHERE ")) {
        $sql .= " And " . $filter_string;
    }else{
        $sql .= " Where " . $filter_string;
    }
}
$n = 0;
if (qssession("tally_tally") != "") {
    $parampage = explode("||", qssession("tally_tally"));
    $n = count($parampage);
}
$current_page = 1;
$page_size  = 10;
if ($n > 0) {
    if ($parampage[0] != "") {
        $current_page = $parampage[0];
    }
    if ($parampage[1] != "") {
        $page_size = $parampage[1];
    }
}
if (qsrequest("page")<>"") {
    $current_page = qsrequest("page");
}
else if (qssession("tally_tally_PageNumber")) {
    $current_page = qssession("tally_tally_PageNumber");
}
else {
    $current_page = 1;
}
$_SESSION["tally_tally_PageNumber"] = $current_page;
if (qsrequest("page_size")<>"") {
    if(qsrequest("page_size") != $page_size) {
        $current_page = 1;
    }
    $page_size = qsrequest("page_size");
}
$_SESSION["tally_tally"] = $current_page . "||" . $page_size;
if (qsrequest("sortfield") != "") {
    $_SESSION["tally_sortfield"] = qsrequest("sortfield");
}
if (qsrequest("sortby") != "") {
    $_SESSION["tally_sortby"] = qsrequest("sortby");
}
if (qssession("tally_sortfield")) {
    $sql = $sql . " " . $SQL_GroupOnly;
    $sql = $sql . " Order By " . stripslashes(qssession("tally_sortfield")) . " " . stripslashes(qssession("tally_sortby"));
    $sortstring = "&sortfield=" . qssession("tally_sortfield") . "&sortby="  . qssession("tally_sortby");
} else {
    $sql = $sql . " " . $sql_ext;
}
?>
<HTML>
<HEAD>
    <style>
        body{margin:0;
            border:0;
        }
        #header{
            background:#416271;
            color:#6CF;
            width:80%;
            height:40px;
            float: none;
        }
        #data{
            background:#00CCFF;
            color:#333333;
            width:80%;
            height:588px;}
        #footer{
            background: #333333;
            color:#000099;
            width:80%;
            height:30px;
            float:none;
        }
        #interface{
            background:#F8FDBB;
            border-radius:30px;
        }
        a hover{
            background:#F8FDBB;
            color:#FFFFFF;
        }
    </style>
    <Title>tally Data</Title>
    <script type="text/javascript" src="./js/yahoo-min.js" ></script>
    <script type="text/javascript" src="./js/dom-min.js" ></script>
    <script type="text/javascript" src="./js/event-min.js" ></script>

    <script type="text/javascript">
        YAHOO.util.Event.onDOMReady( function() { qsPageOnLoadController(); } );

    </script>
    <link rel="stylesheet" type="text/css" href="./css/ContentLayout.css"></link>
    <script type="text/javascript">
        var qsPageItemsCount = 7
        var _Id                                       = 0;
        var _Position                                 = 1;
        var _Name                                     = 2;
        var _Platform                                 = 3;
        var _Picture                                  = 4;
        var _Votecount                                = 5;
        var _Sy                                       = 6;
        var fieldPrompts = [];
        fieldPrompts[_Id] = "Id";
        fieldPrompts[_Position] = "Position";
        fieldPrompts[_Name] = "Name";
        fieldPrompts[_Platform] = "Platform";
        fieldPrompts[_Picture] = "Picture";
        fieldPrompts[_Votecount] = "Votecount";
        fieldPrompts[_Sy] = "Sy";

        // Declare Fields Technical Names
        var fieldTechNames = [];
        fieldTechNames[_Id] = "Id";
        fieldTechNames[_Position] = "Position";
        fieldTechNames[_Name] = "Name";
        fieldTechNames[_Platform] = "Platform";
        fieldTechNames[_Picture] = "Picture";
        fieldTechNames[_Votecount] = "Votecount";
        fieldTechNames[_Sy] = "Sy";
        function qsAssignElementIDs() {
            var TDs = document.getElementsByTagName("td");
            for (var i=0; i < TDs.length; i++) {
                var element = TDs[i];
                if (element.className == "ThRows" || element.className == "TrOdd") {
                    for (var f=0; f < qsPageItemsCount; f++) {
                        if (element.innerHTML == fieldPrompts[f]) {
                            element.id = fieldTechNames[f] + "_caption_cell";
                            element.innerHTML = "<div id='" + fieldTechNames[f] + "_caption_div'>" + element.innerHTML + "</div>";
                        }
                    }
                }
            }
        }
        function qsPageItemsAbstraction() {
        }
    </script>
    <script type="text/javascript">

        // This function dynamically assigns custom events
        // to page item controls on this page
        function qsAssignPageItemEvents() {
        }

    </script>





    <link href="candidate.css" rel="stylesheet" type="text/css">
    </style>
    <! -- <<Client Includes" [clientincludes] [PAGEEVENT] [START] [JS] [E9DD7270-3CF2-473E-8A8E-513B25156014]-->
    <!-- << END OF "tally Data -> Client Includes" [clientincludes] [PAGEEVENT] [START] [JS] [E9DD7270-3CF2-473E-8A8E-513B25156014]--!>
    <script>
        function usrEvent__tally_Data__onload() {
        }
        function usrEvent__tally_Data__onunload() {}
        function usrEvent__tally_Data__onresize() {}
        function qsPageOnUnloadController() {
        }
        function qsPageOnResizeController() {
            var lastResult = false
            return true;
        }
        function qsPageOnLoadController() {
            var lastResult = false
            qsPageItemsAbstraction();
            qsAssignElementIDs();
            qsAssignPageItemEvents();
            YAHOO.util.Event.addListener(window, "beforeunload", qsPageOnUnloadController);
            YAHOO.util.Event.addListener(window, "resize", qsPageOnResizeController);
            return true;
        }

    </script>
    <meta name="generator" content="dbQwikSite Ecommerce"><meta name="dbQwikSitePE" content="QSFREEPE">
</HEAD>
<BODY>
<SCRIPT language=JavaScript>
    function cell_over(cell, classname) {
        if (document.all || document.getElementById) {
            cell.classBackup = cell.className;
            cell.className   = classname;
        }
    }
    function cell_out(cell)
    {
        if (document.all || document.getElementById) {
            cell.className   = cell.classBackup;
        }
    }
</SCRIPT>
<Center>
    <center>
        <div id="header">
  <span class="style1"><font size="5" color="#FFFFFF">
Tally Sheet </font></span>
            <hr /></center>
    <div id="data">

        <?php
        $result = mysql_query($sql)
        or die("Invalid query");
        if (!$result){
        }
        $num_rows = mysql_num_rows($result);
        $page_count = ceil($num_rows/$page_size);
        if ($current_page > $page_count) { $current_page = 1; }
        if ($current_page < 1) { $current_page = 1; }
        if ($page_count < 1) { $page_count = 1; }
        if ($filter_string !=""){
            print "Found ".$num_rows. " record(s)";
            print "<br>";
        }
        ?>

        <?php
        if ($num_rows > 0) {
            ?><br><br>
            <Table  id="masterDataTable"  Border="0" Cellpadding="2" Cellspacing="1"BgColor="#FFFFFF">
                <tr>
                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[0], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[0], qssession("tally_sortby"),  "Sort Descending");
                    ?>

                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[1], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[1], qssession("tally_sortby"),  "Sort Descending");
                    ?>
                    <td id="Position_caption_cell" class="ThRows"  NOWRAP ><a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[1]));?>&sortby=ASC<?php print $navqry_string; ?>"><?php print $nextsortasc; ?></a>
                        &nbsp;<span id="Position_caption_div">Position</span>&nbsp;
                        <a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[1]));?>&sortby=DESC<?php print $navqry_string; ?>"><?php print $nextsortdesc; ?></a></td>
                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[2], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[2], qssession("tally_sortby"),  "Sort Descending");
                    ?>
                    <td id="Name_caption_cell" class="ThRows"  NOWRAP ><a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[2]));?>&sortby=ASC<?php print $navqry_string; ?>"><?php print $nextsortasc; ?></a>
                        &nbsp;<span id="Name_caption_div">Name</span>&nbsp;
                        <a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[2]));?>&sortby=DESC<?php print $navqry_string; ?>"><?php print $nextsortdesc; ?></a></td>
                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[3], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[3], qssession("tally_sortby"),  "Sort Descending");
                    ?>
                    <td id="Platform_caption_cell" class="ThRows"  NOWRAP ><a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[3]));?>&sortby=ASC<?php print $navqry_string; ?>"><?php print $nextsortasc; ?></a>
                        &nbsp;<span id="Platform_caption_div">Platform</span>&nbsp;
                        <a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[3]));?>&sortby=DESC<?php print $navqry_string; ?>"><?php print $nextsortdesc; ?></a></td>
                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[4], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[4], qssession("tally_sortby"),  "Sort Descending");
                    ?>
                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[5], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[5], qssession("tally_sortby"),  "Sort Descending");
                    ?>
                    <td id="Votecount_caption_cell" class="ThRows"  NOWRAP ><a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[5]));?>&sortby=ASC<?php print $navqry_string; ?>"><?php print $nextsortasc; ?></a>
                        &nbsp;<span id="Votecount_caption_div">Votecount</span>&nbsp;
                        <a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[5]));?>&sortby=DESC<?php print $navqry_string; ?>"><?php print $nextsortdesc; ?></a></td>
                    <?php
                    $nextsortasc = qssortasc(qssession("tally_sortfield"), $fields[6], qssession("tally_sortby"),  "Sort Ascending");
                    $nextsortdesc = qssortdesc(qssession("tally_sortfield"), $fields[6], qssession("tally_sortby"),  "Sort Descending");
                    ?>
                    <td id="Sy_caption_cell" class="ThRows"  NOWRAP ><a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[6]));?>&sortby=ASC<?php print $navqry_string; ?>"><?php print $nextsortasc; ?></a>
                        &nbsp;<span id="Sy_caption_div">Study year</span>&nbsp;
                        <a href="tally.php?sortfield=<?php print urlencode(stripslashes($fields[6]));?>&sortby=DESC<?php print $navqry_string; ?>"><?php print $nextsortdesc; ?></a></td>
                </tr>
                <?php
                $rowcount = 0;
                $current_row = ($current_page - 1)*$page_size;
                if (($num_rows > 0) && ($current_row < $num_rows)){
                    mysql_data_seek($result, $current_row);
                }
                while (($row = mysql_fetch_array($result)) && ($rowcount < $page_size)) {

                    $intColCount = 0;

                    if (($rowcount%2) == 0) {
                        $css_class = "\"TrOdd\"";
                    } else {
                        $css_class = "\"TrRows\"";
                    }
                    print "<tr class=" . $css_class . " onmouseover=\"cell_over(this, 'TrHover')\"  onmouseout=\"cell_out(this)\">";


                    $intColCount++;
                    $intColIndex = 0;

                    $cellvalue = "" . number_format($row[0],0,".",",") . "";
                    $intColCount++;
                    $intColIndex = 1;

                    $cellvalue = "" . $row[1] . "";
                    if ($cellvalue != "") {
                        $cellvalue = str_replace(array("\n\r","\r\n","\n","\r"),"<br>",$cellvalue);
                    }
                    else {
                        $cellvalue = "&nbsp;";
                    }
                    print "<td align=Default >";
                    print $cellvalue;
                    print "</td>";
                    $intColCount++;
                    $intColIndex = 2;

                    $cellvalue = "" . $row[2] . "";
                    if ($cellvalue != "") {
                        $cellvalue = str_replace(array("\n\r","\r\n","\n","\r"),"<br>",$cellvalue);
                    }
                    else {
                        $cellvalue = "&nbsp;";
                    }
                    print "<td align=Default >";
                    print $cellvalue;
                    print "</td>";
                    $intColCount++;
                    $intColIndex = 3;

                    $cellvalue = "" . $row[3] . "";
                    if ($cellvalue != "") {
                        $cellvalue = str_replace(array("\n\r","\r\n","\n","\r"),"<br>",$cellvalue);
                    }
                    else {
                        $cellvalue = "&nbsp;";
                    }
                    print "<td align=Default >";
                    print $cellvalue;
                    print "</td>";

                    $intColCount++;
                    $intColIndex = 5;

                    $cellvalue = "" . number_format($row[5],0,".",",") . "";
                    print "<td align=Right >";
                    print $cellvalue;
                    print "</td>";
                    $intColCount++;
                    $intColIndex = 6;

                    $cellvalue = "" . $row[6] . "";
                    if ($cellvalue != "") {
                        $cellvalue = str_replace(array("\n\r","\r\n","\n","\r"),"<br>",$cellvalue);
                    }
                    else {
                        $cellvalue = "&nbsp;";
                    }
                    print "<td align=Default >";
                    print $cellvalue;
                    print "</td>";
                    print "</tr>";
                    $rowcount = $rowcount + 1;
                }//end while
                ?>
            </Table>
            <br>
            <?php
        }else{
            ?>

            <?php
            if ($filter_string != ""){
                ?><Table Border="0" Cellspacing="1" bgcolor="#CCCCCC" >
                    <tr>
                        <td height="80" align="Default" bgcolor="#FFFFFF">
                            <font color="#000099" size="2">
                                No record matched your search criteria.
                            </font>
                        </td>
                    </tr>
                </Table><br>

                <?php
            }else{
                ?><Table Border="0" Cellspacing="1" bgcolor="#CCCCCC" >
                    <tr>
                        <td height="80" align="Default" bgcolor="#FFFFFF">
                            <font color="#000099" size="2">
                                No record found.
                            </font>
                        </td>
                    </tr>
                </Table><br>

                <?php
            }
        }
        if ($qry_string != "") {
            $navqry_string = "&" . $qry_string;
        } else {
            $navqry_string = "";
        }
        print "<table height=\"30\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
        print "<tr align=\"center\" valign=\"middle\">";

        print "<form action=\"tally.php\" method=\"post\" name=\"QSSelectPage\">";

        print "<td width=\"35\" align=\"center\"><A HREF=\"tally_search.php?" . $qry_string . "\"><img src=\"images/bt_qssearch.gif\" border=\"0\" align=\"absmiddle\" title=\"Search\"></A></td><td width=\"8\"></td>";
        if ($current_page > 1) {
            print "<td width=\"35\" align=\"center\"><A HREF=\"tally.php?page=" . ($current_page - 1) . "\"><img src=\"images/bt_qsback.gif\" border=\"0\" align=\"absmiddle\" title=\"Previous\"></A></td><td width=\"8\"></td>";
        } else {
            print "<td width=\"35\" align=\"center\"><img src=\"images/bt_qsback_inact.gif\" border=\"0\" align=\"absmiddle\" title=\"Previous\"></td><td width=\"8\"></td>";
        }
        print "<td width=\"35\" align=\"center\"><select name=\"page\"  onChange=\"window.location='tally.php?page=' + this.value; \">";
        for ($i = 1; $i <= $page_count; $i++) {
            if ($i == $current_page) {
                print "<option value=\"". $i . "\" selected>" . ($i) . "</option>";
            } else {
                print "<option value=\"". $i . "\">" . ($i) . "</option>";
            }
        }
        print "</select></td><td width=\"8\"></td>";
        if ($current_page < $page_count) {
            print "<td width=\"35\" align=\"center\"><A HREF=\"tally.php?page=" . ($current_page + 1) . "\"><img src=\"images/bt_qsnext.gif\" border=\"0\" align=\"absmiddle\" title=\"Next\"></A></td><td width=\"8\"></td>";
        } else {
            print "<td width=\"35\" align=\"center\"><img src=\"images/bt_qsnext_inact.gif\" border=\"0\" align=\"absmiddle\" title=\"Next\"></td><td width=\"8\"></td>";
        }
        print "<td width=\"35\" align=\"center\"><A HREF=#TOP><img src=\"images/bt_qstop.gif\" border=\"0\" align=\"absmiddle\" title=\"Top\"></A></td><td width=\"8\"></td>";
        print "</form>";
        print "</tr>";
        print "</table>";
        print "<br>";
        ?>
        <?php
        if ($result > 0) {mysql_free_result($result);}
        if ($link > 0) {mysql_close($link);}
        ?>


        <p><a href="home.php"> Home</a> || <a href="tally_rep.php">Download Report</a> || <a href="clear.php">Clear Vote</a> </p>
    </div>
    <div id="footer">
        <font color="#FFFFFF" size="4">Copyright &copy; <?php echo date ("Y");?>
            | Designed by  ShikunyeB.
    </div>

</Center>

</BODY>
</HTML>
