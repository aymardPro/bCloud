<?php
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));



class PDF extends FPDF
{
    // En-t�te
    function Header()
    {
        $this->Image('http://127.0.0.1/bCloud/img/ptci-ent1.png', 0, $this->y, 210, 0, 'PNG');
        
        $line1 = "";
        $line2 = "";
        
        $this->SetFont('Arial','', 8);
        $this->SetY(35);
        $this->Cell( 0, 2, utf8_decode($line1), 0, 1, 'R');
        $this->Cell( 0, 5, utf8_decode($line2), 0, 1, 'R');
        
        // dessine un rectangle
        //$this->Rect($this->x, 33, 189, 0, 'D');
        
        $this->Ln(10);
    }
    
    // Pied de page
    function Footer()
    {
    	
        //$this->Image('http://127.0.0.1/bCloud/img/ptci-ent2.png', 0, 0, 210, 0, 'PNG');
        
        // Positionnement � 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Num�ro de page
        
        $this->Image('http://127.0.0.1/bCloud/img/ptci-ent2.png' ,20,270,190,26);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }
    
    // cadre
    
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
        {
            $k = $this->k;
            $hp = $this->h;
            if($style=='F')
                $op='f';
            elseif($style=='FD' || $style=='DF')
                $op='B';
            else
                $op='S';
            $MyArc = 4/3 * (sqrt(2) - 1);
            $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
            $xc = $x+$w-$r ;
            $yc = $y+$r;
            $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
    
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
            $xc = $x+$w-$r ;
            $yc = $y+$h-$r;
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
            $xc = $x+$r ;
            $yc = $y+$h-$r;
            $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
            $xc = $x+$r ;
            $yc = $y+$r;
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
            $this->_out($op);
        }
    
        function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
        {
            $h = $this->h;
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
                $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
        }
    
    
    // création de tableau 
    
    
    
    var $widths;
    var $aligns;
    
    function SetWidths($w)
    {
        //Tableau des largeurs de colonnes
        $this->widths=$w;
    }
    
    function SetAligns($a)
    {
        //Tableau des alignements de colonnes
        $this->aligns=$a;
    }
    
    function Row($data)
    {
        //Calcule la hauteur de la ligne
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Effectue un saut de page si nécessaire
        $this->CheckPageBreak($h);
        //Dessine les cellules
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Sauve la position courante
            $x=$this->GetX();
            $y=$this->GetY();
            //Dessine le cadre
            $this->Rect($x,$y,$w,$h);
            //Imprime le texte
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Repositionne à droite
            $this->SetXY($x+$w,$y);
        }
        //Va à la ligne
        $this->Ln($h);
    }
    
    function CheckPageBreak($h)
    {
        //Si la hauteur h provoque un débordement, saut de page manuel
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    
    function NbLines($w,$txt)
    {
        //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

}