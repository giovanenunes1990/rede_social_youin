<?php 
date_default_timezone_set('America/Sao_Paulo');

function timesGo($date){
    
    $today = new DateTime(date('Y-m-d H:i:s'));
    $posted = new Datetime($date);
    $diff = $posted->diff($today);
    
    $years = $diff->format('%Y');
    $mouths = $diff->format('%m');
    $days = $diff->format('%d');
    $hours = $diff->format('%H');
    $minutes = $diff->format('%i');


        if($years <= 0){

            if($mouths == 0){
                
                if($days == 0){
                    
                    if($hours == 0){

                        if($minutes == 0){
                            return 'Agora mesmo...';
                        }else if($minutes == 1){
                            return 'Há 1 minuto...';
                        }else if($minutes > 1){
                            return  $diff->format('Há %i minutos atrás...');
                        }
                        
                    }else if($hours == 1){
                        return 'Há 1 hora atrás...';
                    }else if($hours > 1){
                        return  $diff->format('Há %H horas atrás...');
                    }

                }else if($days == 1){
                    return 'Há 1 dia atrás...';
                }else if($days > 1){
                    return $diff->format('Há %d dias atrás...');
                }

            }else if($mouths == 1){
                return 'Há 1 mês atrás...';
            }else if($mouths > 1){
                return $diff->format('Há %m meses atrás...');
            }

        }else if($years == 1){
            return 'Há 1 ano atrás';
        }else if($years > 1){
            return $diff->format('Há %Y anos atrás...');
        }
       
       

}

function timesGoChat($date){
    
    $today = new DateTime(date('Y-m-d H:i:s'));
    $posted = new Datetime($date);
    $diff = $posted->diff($today);
    
    $years = $diff->format('%Y');
    $mouths = $diff->format('%m');
    $days = $diff->format('%d');
    $hours = $diff->format('%H');
    $minutes = $diff->format('%i');


        if($years <= 0){

            if($mouths == 0){
                
                if($days == 0){
                    
                    if($hours == 0){

                        if($minutes == 0){
                            return 'há poucos segundos';
                        }else if($minutes == 1){
                            return 'há 1 minuto';
                        }else if($minutes > 1){
                            return  $diff->format('há %i minutos');
                        }
                        
                    }else if($hours == 1){
                        return 'há 1 hora atrás';
                    }else if($hours > 1){
                        return  $diff->format('há %H horas atrás');
                    }

                }else if($days == 1){
                    return 'há 1 dia ';
                }else if($days > 1){
                    return $diff->format('há %d dias');
                }

            }else if($mouths == 1){
                return 'há 1 mês';
            }else if($mouths > 1){
                return $diff->format('há %m meses');
            }

        }else if($years == 1){
            return 'há 1 ano';
        }else if($years > 1){
            return $diff->format('há %Y anos');
        }
       
       

}