<?php
    include("./includes/connect.php");
    include("./includes/conditions.php");
    if(isset($_GET["groupno"])){
        $group_no=$_GET["groupno"];
    }
    // else{
    //     header("Location: /logbook_online/onlinelogbook/procord/procord-view.php");
    //     exit;
    // }
    require('fpdf.php');

    $year_now = date("y");

    $sql="select * from groups where groupno=$group_no";
    $res= mysqli_query($conn, $sql)->fetch_assoc();
    $semester = $res["sem"];
    $year = $res["year"];
    $title= $res["title"];
    $guide_id = $res["guide_id"];
    $sql_i = "select * from userinfo where username = '$guide_id'";
    $res_i = mysqli_query($conn, $sql_i)->fetch_assoc();
    $guide_name = $res_i["name"];

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
            $this->Rect($x,$y,$w,$h);
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
            global $year_now, $year, $semester;
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
            $this->Cell(0,45,'Academic Year 20'.date("y",strtotime("-1 year")) . " - 20" . $year_now,0,0,'C');
            $this->SetX($this->lMargin);
            $this->Cell(100,60,'Year : '.$year,0,0,'C');
            // $this->SetX($this->lMargin);
            $this->Cell(80,60,'Sem : '.$semester,0,0,'C');
            $this->Ln(20);
        }

        // Page footer
        function Footer()
        {
            global $guide_name;
            $this->SetY(-27);
            $this->SetFont('Times','B',12);
            $this->Cell(0,10,'Project Guide',0,0,'L');
            $this->SetX($this->lMargin);
            $this->Cell(0,10,'Project Co-ordinator',0,0,'C');
            $this->SetX($this->lMargin);
            $this->Cell( 0, 10, 'Head of Department', 0, 0,'R');
            $this->SetY(-20);
            $this->Cell( 0, 10, 'Guide Name: ' . $guide_name, 0, 0,'L');
            // Position at 1 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
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
    
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(0,40,'Project Title : ' . $title, 0, 1, 'C');
    $pdf->Line(10, 55, 210-10, 55);
    $sql="select * from groups where groupno=$group_no";
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

    $query = "select * from log_content where groupno =$group_no";
    $result = mysqli_query($conn, $query);
    
    while ($data = $result->fetch_assoc()) {
        $y2=50;
        $progress_planned = $data['progress_planned'];
        $progress_achieved = $data['progress_achieved'];
        $guide_review = $data["guide_review"];
        $date_of_log_sub = $data["date"];
        $log_no = $data["log_no"];

        $sql_for_grps = "select * from groups g join userinfo u on g.student_id=u.username where groupno=$group_no";
        $res_for_grps = mysqli_query($conn, $sql_for_grps);

        $pdf->AddPage();
        $pdf->Line(10, $y2-5, 210-10, $y2-5);
        $pdf->SetY($y2+2);
        $pdf->Cell(0,0,'Log No : ' . $log_no, 0, 1, 'L');

        // $pdf->SetFont('Arial','B',15);
        // $pdf->Line(10, $y2+8, 210-10, $y2+8);
        // $pdf->SetY($y2+13);
        // $pdf->Cell(0,0,'Progress Planned :', 0, 1, 'L');

        // $pdf->SetFont('Arial','',13);
        // $pdf->WordWrap($progress_planned,190);
        // $pdf->SetY($y2+18);
        // $pdf->Write(6,$progress_planned);
        // $pdf->Line(10, $y2+58, 210-10, $y2+58);

        // $pdf->SetFont('Arial','B',15);
        // $pdf->SetY($y2+63);
        // $pdf->Cell(0,0,'Progress Achieved :', 0, 1, 'L');

        // $pdf->SetFont('Arial','',13);
        // $pdf->WordWrap($progress_achieved,190);
        // $pdf->SetY($y2+68);
        // $pdf->Write(6,$progress_achieved);
        // $pdf->Line(10, $y2+108, 210-10, $y2+108);

        $pdf->SetY($y2+8);
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(95,12,'Progress Planned', 'L T R', 0, 'L');
        $pdf->Cell(95,12,'Progress Achieved', 'L T R', 0, 'L');

        $pdf->SetFont('Arial','',15);
        // 
        // $pdf->SetY($y2+20);
        // $pdf->Cell(95,100,'', 1, 0, 'L');
        // $pdf->Cell(95,100,'', 1, 0, 'L');
        // $pdf->Write(6,$progress_planned);

        // $pdf->SetXY(105, $y2+20);
        // $pdf->Write(6,$progress_achieved);

        // for ($x = 0; $x <= $nb; $x++) {
        //     $pdf->Cell(95,100,'', 1, 0, 'L');
        // }

        $pdf->SetY($y2+20);
        $pdf->SetWidths(array(95, 95));
        for($i=0;$i<1;$i++){
            $pdf->Row(array($progress_planned, $progress_achieved));
        }

        

        $pdf->SetFont('Arial','B',15);
        $pdf->Line(10, $y2+108, 210-10, $y2+108);
        $pdf->SetY($y2+113);
        $pdf->Cell(0,0,'Guides Review :', 0, 1, 'L');

        $pdf->SetFont('Arial','',15);
        $pdf->WordWrap($guide_review,190);
        $pdf->SetY($y2+118);
        $pdf->Write(6,$guide_review);
        $pdf->Line(10, $y2+155, 210-10, $y2+155);

        // $pdf->SetFont('Arial','',15);
        // $guide_review_text='Guide Review : ' . $guide_review;
        // $pdf->WordWrap($guide_review_text,190);
        // $pdf->SetY($y2+125);
        // $pdf->Write(6,$guide_review_text);

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
    $pdf->Output();
?>