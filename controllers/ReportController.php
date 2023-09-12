<?php
class ReportController extends AbstractController{
    
    
    public function Index() {   
        return html('report/index.php');
    }

    public function EducationView() {   
        set('competencias',listCompetence());
        set('status', listStatus());
   
        set('filter', params('filter'));
        if(params('filter') == 'Todos'){
            set('dependentes', listEducation('fechado'));        
            set('competencia', 'Todos');
        } else{
            set('dependentes', listEducationComp(params('filter'), '' ,'fechado'));        
            set('competencia', params('filter'));   
        }        

        return html('report/view.php');

    }
    
    public function EducationViewPost() {   
        set('competencias',listCompetence());
        set('status', listStatus());
 
        $data = AppointmentController::education_data_from_form();
        $data_obj = make_model_object($data);
        
        if($data_obj->comp == '' && $data_obj->status == ''){
            set('dependentes', listEducation('fechado'));        
            set('competencia', 'Todos');
        } else{
            set('dependentes', listEducationComp($data_obj->comp, $data_obj->status, 'fechado'));        
            set('competencia', $data_obj->comp);   
        }        
     

        return html('report/view.php');

    }
    
}