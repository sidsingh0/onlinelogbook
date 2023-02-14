<?php
    include("./includes/connect.php");
    include("./includes/conditions.php");
    if(isset($_GET["groupno"])){
        $group_no=$_GET["groupno"];
        $year_of=$_GET["year"];
        $div_of=$_GET["div"];
        $sem=$_GET["sem"];
        $aca_year=$_GET["acayear"];
        $dept=$_GET["dept"];
    }
    else{
        header("Location: /logbook_online/onlinelogbook/procord/view-logs.php");
        exit;
    }
    require('fpdf.php');

    // $year_now = date("y");

    $sql="select * from groups where ((groupno=$group_no and sem='$sem') and (division='$div_of' and year='$year_of')) and (aca_year='$aca_year' and dept='$dept')";
    // $sql="select * from groups where groupno=$group_no";
    $res= mysqli_query($conn, $sql)->fetch_assoc();
    // $semester = $res["sem"];
    // $year = $res["year"];
    $title= $res["title"];
    $guide_id = $res["guide_id"];
    $sql_i = "select * from userinfo where username = '$guide_id'";
    $res_i = mysqli_query($conn, $sql_i)->fetch_assoc();
    $guide_name = $res_i["name"];

    $sql_proconame="select u.name from userinfo as u JOIN procos as p ON u.username = p.username WHERE (sem='$sem' AND year='$year_of') AND p.dept='$dept'";
    $res_proconame=mysqli_query($conn, $sql_proconame)->fetch_assoc();
    $proco_name = $res_proconame["name"];

    class PDF extends FPDF
    {

        protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,95,92);
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Page header
        function Header()
        {
            global $year_of, $sem, $aca_year, $div_of, $dept;
            $aca_year_prev = $aca_year - 1;
            // Arial bold 15
            $this->SetFont('Times','B',20);
            //$this->Line(10, 5, 210-10, 5);
            // Move to the right
            $this->Cell(80);
            // Title
            $this->Cell(30,10,'A. P. Shah Institue of Technology',0,0,'C');
            $this->SetX($this->lMargin);
            // Line break
            $this->Line(10, 25, 210-10, 25);
            $this->SetFont('Arial','',15);
            $this->Cell(0,45,'Academic Year '.$aca_year_prev.' - '.$aca_year,0,0,'C');
            $this->SetX($this->lMargin);
            $this->Cell(100,60,'Dept : '.$dept,0,0,'L');
            $this->SetX($this->lMargin);
            $this->Cell(140,60,'Year : '.$year_of,0,0,'C');
            $this->SetX($this->lMargin);
            $this->Cell(250,60,'Sem : '.$sem,0,0,'C');
            $this->SetX($this->lMargin);
            $this->Cell(190,60,'Div : '.$div_of,0,0,'R');
            $this->Ln(20);
        }

        // Page footer
        function Footer()
        {
            global $guide_name, $proco_name;
            $this->SetY(-27);
            $this->SetFont('Times','B',12);
            $this->Cell(0,10,'Project Guide',0,0,'L');
            $this->SetX($this->lMargin);
            $this->Cell(0,10,'Project Co-ordinator',0,0,'C');
            $this->SetX($this->lMargin);
            $this->Cell( 0, 10, 'Head of Department', 0, 0,'R');
            $this->SetY(-20);
            $this->Cell( 0, 10, $guide_name, 0, 0,'L');
            $this->SetX($this->lMargin);
            $this->Cell( 0, 10, $proco_name, 0, 0,'C');
            // Position at 1 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,13,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function WordWrap(&$text, $maxwidth)
        {
            $text = trim($text);
            if ($text==='')
                return 0;
            $space = $this->GetStringWidth(' ');
            $lines = explode("\n", $text);
            $text = '';
            $count = 0;

            foreach ($lines as $line)
            {
                $words = preg_split('/ +/', $line);
                $width = 0;

                foreach ($words as $word)
                {
                    $wordwidth = $this->GetStringWidth($word);
                    if ($wordwidth > $maxwidth)
                    {
                        // Word is too long, we cut it
                        for($i=0; $i<strlen($word); $i++)
                        {
                            $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                            if($width + $wordwidth <= $maxwidth)
                            {
                                $width += $wordwidth;
                                $text .= substr($word, $i, 1);
                            }
                            else
                            {
                                $width = $wordwidth;
                                $text = rtrim($text)."\n".substr($word, $i, 1);
                                $count++;
                            }
                        }
                    }
                    elseif($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth + $space;
                        $text .= $word.' ';
                    }
                    else
                    {
                        $width = $wordwidth + $space;
                        $text = rtrim($text)."\n".$word.' ';
                        $count++;
                    }
                }
                $text = rtrim($text)."\n";
                $count++;
            }
            $text = rtrim($text);
            return $count;
        }

        
    }
    
    // First Page (Team Members)
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(0,40,'Project Title : ' . $title, 0, 1, 'C');
    $pdf->Line(10, 55, 210-10, 55);
    $sql="select * from groups where ((groupno=$group_no and sem='$sem') and (division='$div_of' and year='$year_of')) and (aca_year='$aca_year' and dept='$dept')";
    // $sql="select * from groups where groupno=$group_no";
    $res= mysqli_query($conn, $sql);
    $i=1;
    // $pdf->SetY(45);
    $y1=68;
    while($r=$res->fetch_assoc()){
        $student_id = $r["student_id"];
        $sql_inside = "select * from userinfo where username = '$student_id'";
        $res_inside = mysqli_query($conn, $sql_inside)->fetch_assoc();

        $pdf->SetFont('Arial','B',15);
        $pdf->SetY($y1-5);
        $pdf->Cell(0,0,'Team Member : ' . $i, 0, 1, 'L');
        $pdf->Line(10, $y1, 210-10, $y1);
        $pdf->SetFont('Arial','',15);
        $pdf->SetY($y1+5);
        // $pdf->SetY($y1+($i*50));
        $pdf->Cell(0,0,'Name           : ' . $res_inside["name"], 0, 1, 'L');
        $pdf->SetY($y1+15);
        $pdf->Cell(0,0,'Moodle ID    : ' . $student_id, 0, 1, 'L');
        $pdf->SetY($y1+25);
        $pdf->Cell(0,0,'Email           : ' . $res_inside["email"], 0, 1, 'L');
        $pdf->SetY($y1+35);
        $pdf->Cell(0,0,'Mobile No    : ' . $res_inside["mobile_no"], 0, 1, 'L');
        $pdf->Line(10, $y1+39, 210-10, $y1+39);
        //$pdf->SetY($y1+45);
        $i++;
        
        $y1 = $y1 + 50;
    }

    $query = "select * from log_content where ((groupno=$group_no and sem='$sem') and (division='$div_of' and year='$year_of')) and (aca_year='$aca_year' and dept='$dept')";
    // $query="select * from groups where groupno=$group_no";
    $result = mysqli_query($conn, $query);
    
    // Second page onwards (logs)
    while ($data = $result->fetch_assoc()) {
        $y2=50;
        $progress_planned = $data['progress_planned'];
        $progress_achieved = $data['progress_achieved'];
        $guide_review = $data["guide_review"];
        $date_of_log_sub = $data["date"];
        $log_no = $data["log_no"];

        $sql_for_grps = "select * from groups g join userinfo u on g.student_id=u.username where ((g.groupno=$group_no and g.sem='$sem') and (g.division='$div_of' and g.year='$year_of')) and (g.aca_year='$aca_year' and g.dept='$dept')";
        $res_for_grps = mysqli_query($conn, $sql_for_grps);

        $pdf->AddPage();
        $pdf->Line(10, $y2-5, 210-10, $y2-5);
        $pdf->SetY($y2+2);
        $pdf->Cell(0,0,'Log No : ' . $log_no, 0, 1, 'L');

        $pdf->SetY($y2+8);
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(95,12,'Progress Planned', 'L T R', 0, 'L');
        $pdf->Cell(95,12,'Progress Achieved', 'L T R', 0, 'L');

        $pdf->SetFont('Arial','',15);

        $pdf->SetY($y2+20);
        $pdf->SetWidths(array(95, 95));
        for($i=0;$i<1;$i++){
            $pdf->Row(array($progress_planned, $progress_achieved));
        }

        

        $pdf->SetFont('Arial','B',15);
        // $pdf->Line(10, $y2+108, 210-10, $y2+108);
        $pdf->SetY($y2+117);
        $pdf->Cell(0,0,'Guides Review :', 0, 1, 'L');

        $pdf->SetFont('Arial','',15);
        $pdf->WordWrap($guide_review,190);
        $pdf->SetY($y2+120);
        $pdf->Write(6,$guide_review);
        $pdf->Line(10, $y2+155, 210-10, $y2+155);

        $pdf->SetFont('Arial','B',15);
        $pdf->SetY($y2+160);
        $pdf->Cell(0,0,'Signatures :', 0, 1, 'L');

        $pdf->SetFont('Arial','B',15);
        $pdf->SetY($y2+202);
        $pdf->Cell(0,0,'Date : '.$date_of_log_sub, 0, 1, 'L');

        $i=1;
        $y2 = $y2 + 160;
        $pdf->SetFont('Arial','',15);
        while($d=$res_for_grps->fetch_assoc()){
            $y2 = $y2 + 8;
            $pdf->SetY($y2);
            $pdf->Cell(0,0,'Team Member '.$i.' : '.$d["student_id"], 0, 1, 'L');
            $i++;
        }

    }
    $logbook_pdf_name='logbook_'.$dept.'_'.$year_of.'-'.$div_of.$group_no.'_Sem-'.$sem.'.pdf';
    $pdf->Output('I', $logbook_pdf_name);
?>