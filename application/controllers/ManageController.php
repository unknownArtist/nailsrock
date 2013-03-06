<?php

class ManageController extends Zend_Controller_Action
{
    public function init()
    {
        if (My_Auth::getInstance()->isAdmin() || My_Auth::getInstance()->isVIPMember())
        {


            // die ("yes");
        } else
        {

            $this->_helper->FlashMessenger->setNamespace('warning')->addMessage('Access Denied');

            $this->_redirect('/');
        }
    }

    public function operationsAction()
    {

    }

    public function indexAction()
    {

    }

    public function editServiceAction()
    {


        $form = new Application_Form_Service();

        $Services = new Application_Model_Services();


        $id = $this->_getParam('id');

        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData))
            {
                $Services->update(array(

                    'serviceName' => $form->getValue('serviceName'),
                    'duration' => $form->getValue('duration'),
                    ), 'serviceID=' . $form->getValue('serviceID'));
                $form->reset();
                $this->_redirect('manage/services');
                $this->view->successMsg = "Service Update Successfully";
            } else
            {
                $form->populate($formData);

            }
        } else
        {
            $Service = $Services->find($id)->current();
            $form->serviceName->setValue($Service->serviceName);
            $form->duration->setValue($Service->duration);
            $form->serviceID->setValue($id);
            $form->submit->setLabel('Save Service');
            $this->view->form = $form;
            $this->view->id = $id;
        }


    }
    public function addServicesAction()
    {

        $this->view->form = $form = new Application_Form_Service();

        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData))
            {
                $Services = new Application_Model_Services();
                $Services->insert(array(

                    'serviceName' => $form->getValue('serviceName'),
                    'duration' => $form->getValue('duration'),
                    ));
                $form->reset();
                $this->_redirect('manage/services');
                $this->view->successMsg = "Service Edited Successfully";
            } else
            {
                $form->populate($formData);

            }
        } else
        {

        }
    }
    


    public function servicesAction()
    {

        //(start) added by sehrish
        $Services = new Application_Model_Services();

        $getConnect = Zend_Db_Table::getDefaultAdapter();
        $getDbTable = new Zend_Db_Select($getConnect);


        $getservices = $getDbTable->from('services');
        $getResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($getservices));

        $Paginatedresult = $getResult->setItemCountPerPage(10)->setCurrentPageNumber($this->
            _getParam('page', 1));
        $this->view->Services = $Paginatedresult;
        //end


    }


    public function shopHoursAction()
    {


        $form = new Application_Form_Shophours();
        $formCustomHours = new Application_Form_Shopcustomhours();
        $this->view->formCustomHours = $formCustomHours;

        $shophours = new Application_Model_Shophours();

        if (!$this->getRequest()->isPost())
        {


            $rows = $shophours->fetchAll(Zend_Db::FETCH_OBJ)->toArray();


            if (is_array($rows))
            {

                foreach ($rows as $row)
                {

                    $row = (object)$row;

                    switch ($row->day)
                    {
                        case 'Sunday':
                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->sunCloseAllDay->setAttrib('checked', 1);

                            }

                            $form->sunCloseAllDay->setValue($closeAllday);


                            $form->sunOpen->setValue($row->open);
                            $form->sunClose->setValue($row->close);
                            break;

                        case 'Monday':

                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->monCloseAllDay->setAttrib('checked', 1);

                            }

                            $form->monCloseAllDay->setValue($row->closeAllday);

                            $form->monOpen->setValue($row->open);
                            $form->monClose->setValue($row->close);
                            break;

                        case 'Tuesday':

                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->tueCloseAllDay->setAttrib('checked', 1);

                            }
                            $form->tueCloseAllDay->setValue($row->closeAllday);

                            $form->tueOpen->setValue($row->open);
                            $form->tueClose->setValue($row->close);
                            break;
                        case 'Wednesday':
                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->wedCloseAllDay->setAttrib('checked', 1);

                            }

                            $form->wedCloseAllDay->setValue($row->closeAllday);

                            $form->wedOpen->setValue($row->open);
                            $form->wedClose->setValue($row->close);

                            break;


                        case 'thursday':
                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->thusCloseAllDay->setAttrib('checked', 1);

                            }

                            $form->thusCloseAllDay->setValue($row->closeAllday);

                            $form->thusOpen->setValue($row->open);
                            $form->thusClose->setValue($row->close);
                            break;


                        case 'Friday':
                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->friCloseAllDay->setAttrib('checked', 1);

                            }
                            $form->friCloseAllDay->setValue($row->closeAllday);

                            $form->friOpen->setValue($row->open);
                            $form->friClose->setValue($row->close);
                            break;

                        case 'Saturday':
                            $closeAllday = $row->closeAllday;

                            if ($closeAllday)
                            {
                                $form->satCloseAllDay->setAttrib('checked', 1);

                            }

                            $form->satCloseAllDay->setValue($row->closeAllday);

                            $form->satOpen->setValue($row->open);
                            $form->satClose->setValue($row->close);
                            break;

                    }

                }


            }
            $this->view->form = $form;
        }
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->
            getPost()))
        {


            //       if($form->getValue('sunCloseAllDay')) :

            $data = array(

                'day' => 'Sunday',
                'closeAllday' => $form->getValue('sunCloseAllDay'),
                'open' => $form->getValue('sunOpen'),
                'close' => $form->getValue('sunClose'),

                );

            $where = 'ID=1';


            $shophours->update($data, $where);


            //
            //
            //
            //
            //	    echo '<pre>';
            //        print_r( $data    );
            //        echo '</pre>';
            //
            //        die('DEBUG');
            //


            unset($data);


            //      endif;


            //if($form->getValue('monCloseAllDay')) :


            //////// for monday
            $data = array(
                'day' => 'Monday',
                'closeAllday' => $form->getValue('monCloseAllDay'),
                'open' => $form->getValue('monOpen'),
                'close' => $form->getValue('monClose'),

                );


            $where = 'ID=2';

            $shophours->update($data, $where);
            //
            //
            //
            //	    echo '<pre>';
            //        print_r(  $data   );
            //        echo '</pre>';
            //
            //        die('DEBUG');
            //

            unset($data);


            //  endif;


            //  if($form->getValue('tueCloseAllDay')) :

            $data = array(


                'day' => 'Tuesday',
                'closeAllday' => $form->getValue('tueCloseAllDay'),
                'open' => $form->getValue('tueOpen'),
                'close' => $form->getValue('tueClose'),

                );


            $where = 'ID=3';


            $shophours->update($data, $where);

            unset($data);
            //   endif;

            //    if($form->getValue('wedCloseAllDay')) :

            $data = array(
                'day' => 'Wednesday',
                'closeAllday' => $form->getValue('wedCloseAllDay'),
                'open' => $form->getValue('wedOpen'),
                'close' => $form->getValue('wedClose'),

                );

            $where = 'ID=4';


            $shophours->update($data, $where);


            unset($data);
            //    endif;

            //  if($form->getValue('thusCloseAllDay')) :


            $data = array(
                'day' => 'thursday',
                'closeAllday' => $form->getValue('thusCloseAllDay'),
                'open' => $form->getValue('thusOpen'),
                'close' => $form->getValue('thusClose'),

                );


            $where = 'ID=5';


            $shophours->update($data, $where);

            unset($data);


            //endif;

            //if($form->getValue('friCloseAllDay')) :

            $data = array(
                'day' => 'Friday',
                'closeAllday' => $form->getValue('friCloseAllDay'),
                'open' => $form->getValue('friOpen'),
                'close' => $form->getValue('friClose'),

                );

            $where = 'ID=6';

            $shophours->update($data, $where);
            unset($data);

            //endif;

            //if($form->getValue('satCloseAllDay')) :


            $data = array(


                'day' => 'Saturday',
                'closeAllday' => $form->getValue('satCloseAllDay'),
                'open' => $form->getValue('satOpen'),
                'close' => $form->getValue('satClose'),

                );


            $where = 'ID=7';
            $shophours->update($data, $where);

            unset($data);
            //endif;


            //  $form->reset();

            $this->_redirect('manage/shop-hours');
        }


        //          $form =  new Application_Form_Shopcustomhours();
        //          $this->view->form = $form;

        $shopcustomhours = new Application_Model_Shopcustomhours();
        //          if ($this->getRequest()->isPost() && $this->view->form->isValid($this->_getAllParams()))
        //       {
        //         $h_data = array(

        //                             'date'            =>    $form->getValue('date'),
        //                             'closeAllday'     =>    $form->getValue('closeAllDay'),
        //                             'start'           =>    $form->getValue('start'),
        //                             'end'             =>    $form->getValue('end'),
        //                             'comments'        =>    $form->getValue('comments'),
        //                                      );

        //         $shopcustomhours->insert($h_data);
        //       }
        //         $form->reset();
        $data = $shopcustomhours->fetchAll($where = null, 'ID DESC', '4,0');

        $this->view->data = $data;

    }
    public function employeesAction()
    {


        $Technician = new Application_Model_Technician();
        $allTechnitians = $Technician->fetchAll(Zend_Db::FETCH_OBJ)->toArray();
        $this->view->allTechnitians = $allTechnitians;


        if (!$this->getRequest()->isPost())
        {
            return;
        }

        $Technician = new Application_Model_Technician();

        $type = $_POST['type'];


        switch ($type)
        {
            case 'save':


                $rows = $_POST['id'];
                $Name = $_POST['Name'];
                if (is_array($rows))
                {

                    foreach ($rows as $row)
                    {
                        $technitiab1 = $Technician->find($row)->current();
                        $technitiab1->Name = $Name[$row];
                        $technitiab1->save();
                    }
                }


                break;

            case 'delete':


                $rows = $_POST['id'];
                $Name = $_POST['Name'];
                if (is_array($rows))
                {

                    foreach ($rows as $row)
                    {
                        $technitiab1 = $Technician->find($row)->current();

                        $technitiab1->delete('technicianID=' . $row);
                    }
                }
                break;

            case 'add':


                $u_data = array(

                    'name' => trim($_POST['TechniName']),
                    'status' => '1',
                    );
                $Technician->insert($u_data);


                break;

            default:
        }

        //
        //	    echo '<pre>';
        //        print_r( $_POST    );
        //        echo '</pre>';
        //
        //        die('DEBUG');

        $this->_redirect('manage/employees');


    }
    public function shopCustomHoursAction()
    {


        $form = new Application_Form_Shopcustomhours();
        $this->view->form = $form;

        $shopcustomhours = new Application_Model_Shopcustomhours();
        if ($this->getRequest()->isPost() && $this->view->form->isValid($this->
            _getAllParams()))
        {
            $h_data = array(

                'date' => $form->getValue('date'),
                'closeAllday' => $form->getValue('closeAllDay'),
                'start' => $form->getValue('shopCustomHoursOpen'),
                'end' => $form->getValue('shopCustomHoursClose'),
                'comments' => $form->getValue('comments'),
                );


            $shopcustomhours->insert($h_data);
            $this->_redirect('manage/shop-hours');
        }
        $form->reset();


    }
    public function techniciansListAction()
    {


        $TechniciansList = new Application_Model_Technician();
        $this->view->Technicians = $TechniciansList->fetchAll()->toArray();

    }


    public function editTechnicianAction()
    {
        // application error
        //      $this->getResponse()->setHttpResponseCode(500);


        $Technicians = new Application_Model_Technician();

        $form = new Application_Form_Technician();
        $technicianID = $this->_getParam('technicianID');
        $this->view->technicianID = $technicianID;
        $Technician = $Technicians->find($technicianID)->current();

        $form->technicianID->setValue($technicianID);

        $Technicianhours = new Application_Model_Technicianhours();


        if ($this->getRequest()->isPost())
        {

            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData))
            {
                $Technician = new Application_Model_Technician();

                $technicianID = trim($_POST['technicianID']);

                $where = "technicianID=" . $technicianID;

                $u_data = array(

                    'name' => $form->getValue('name'),
                    'status' => '1',
                    );
                $technicianID = $this->_getParam('technicianID');
                $Technician->update($u_data, 'technicianID=' . $technicianID);

                $select = $Technician->select()->from($Technician)->order('technicianID desc');

                $technicianid = $Technician->fetchRow($select)->toArray();

                $Technicianhours = new Application_Model_Technicianhours();

                // if($form->getValue('sunCloseAllDay')) :

                $sundata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Sunday',
                    'closeAllDay' => $form->getValue('sunCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('sunOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('sunClose')),

                    );
                $where = array('technicianID=' . $technicianID, "day='Sunday'");

                $Technicianhours->update($sundata, $where);

                // endif;


                //if($form->getValue('monCloseAllDay')) :

                //////// for monday
                $mondata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Monday',
                    'closeAllDay' => $form->getValue('monCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('monOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('monClose')),


                    );


                $where = array('technicianID=' . $technicianID, "day='Monday'");

                $Technicianhours->update($mondata, $where);

                //    endif;

                //   if($form->getValue('tueCloseAllDay')) :

                $tuedata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Tuesday',
                    'closeAllDay' => $form->getValue('tueCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('tueOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('tueClose')),


                    );


                $where = array('technicianID=' . $technicianID, "day='Tuesday'");

                $Technicianhours->update($tuedata, $where);

                //////   endif;

                ////  if($form->getValue('wedCloseAllDay')) :

                $weddata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Wednesday',
                    'closeAllDay' => $form->getValue('wedCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('wedOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('wedClose')),


                    );

                $where = array('technicianID=' . $technicianID, "day='Wednesday'");

                $Technicianhours->update($weddata, $where);


                //      endif;

                //   if($form->getValue('thusCloseAllDay')) :


                $thusdata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Thursday',
                    'closeAllDay' => $form->getValue('thusCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('thusOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('thusClose')),


                    );


                $where = array('technicianID=' . $technicianID, "day='Thursday'");

                $Technicianhours->update($thusdata, $where);


                //endif;

                //if($form->getValue('friCloseAllDay')) :

                $fridata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Friday',
                    'closeAllDay' => $form->getValue('friCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('friOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('friClose')),


                    );

                $where = array('technicianID=' . $technicianID, "day='Friday'");

                $Technicianhours->update($fridata, $where);


                //endif;

                //if($form->getValue('satCloseAllDay')) :


                $satdata = array(

                    'technicianID' => $technicianID,
                    'day' => 'Saturday',
                    'closeAllDay' => $form->getValue('satCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('satOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('satClose')),

                    );


                $where = array('technicianID=' . $technicianID, "day='Saturday'");

                $Technicianhours->update($satdata, $where);


                //endif;


                $form->reset();
                //$this->_redirect('manage/services');

                // now populate emplyoee service table


                $Technicianservices = new Application_Model_Technicianservices();

                //      technicianID 	day 	closeAllDay 	open 	close 	date 	open_time_id 	close_time_id
                $rows = $formData['service'];


                //

                //                 	technicianID Ascending 	serviceID 	id

                $Technicianservices->delete("technicianID=" . $_POST['technicianID']);
                $Technicianservicedata['technicianID'] = $_POST['technicianID'];


                if (is_array($rows))
                {

                    foreach ($rows as $row)
                    {

                        $Technicianservicedata['serviceID'] = $row;
                        $Technicianservices->insert($Technicianservicedata);

                    }
                }


                $this->_helper->FlashMessenger->setNamespace('success')->addMessage('Technitian is Created Successfully');

                $this->_redirect('manage/employees');

                $this->view->successMsg = "Service Added Successfully";

            } else
            {
                $form->populate($formData);

            }
        } else
        {
            $TechnicianhoursObjs = $Technicianhours->select()->where('technicianID=' . $this->
                _getParam('technicianID'))->query()->fetchAll(Zend_Db::FETCH_OBJ);


            $rows = $TechnicianhoursObjs;

            if (is_array($rows))
            {

                foreach ($rows as $row)
                {

                    //
                    //
                    //	    echo '<pre>';
                    //        print_r(  $row   );
                    //        echo '</pre>';
                    //
                    //        die('DEBUG');
                    //
                    switch ($row->day)
                    {
                        case 'Sunday':
                            $closeAllDay = $row->closeAllDay;

                            if ($closeAllDay)
                            {
                                $form->sunCloseAllDay->setValue($closeAllDay);
                                $form->sunOpen->setValue($row->open);
                                $form->sunClose->setValue($row->close);
                            }

                            break;

                        case 'Monday':
                            $closeAllDay = $row->closeAllDay;

                            if ($closeAllDay)
                            {
                                $form->monCloseAllDay->setValue($closeAllDay);
                                $form->monOpen->setValue($row->open);
                                $form->monClose->setValue($row->close);
                            }
                            break;

                        case 'Tuesday':
                            $closeAllDay = $row->closeAllDay;

                            if ($closeAllDay)
                            {
                                $form->tueCloseAllDay->setValue($closeAllDay);
                                $form->tueOpen->setValue($row->open);
                                $form->tueClose->setValue($row->close);
                            }
                            break;


                        case 'Wednesday':

                            $closeAllDay = $row->closeAllDay;

                            if ($closeAllDay)
                            {
                                $form->wedCloseAllDay->setValue($closeAllDay);
                                $form->wedOpen->setValue($row->open);
                                $form->wedClose->setValue($row->close);
                            }

                            break;


                        case 'Thursday':
                            $closeAllDay = $row->closeAllDay;
                            if ($closeAllDay)
                            {
                                $form->thusCloseAllDay->setValue($closeAllDay);

                                $form->thusOpen->setValue($row->open);
                                $form->thusClose->setValue($row->close);
                            }
                            break;


                        case 'Friday':
                            $closeAllDay = $row->closeAllDay;

                            if ($closeAllDay)
                            {
                                $form->friCloseAllDay->setValue($closeAllDay);
                                $form->friOpen->setValue($row->open);
                                $form->friClose->setValue($row->close);
                            }
                            break;

                        case 'Saturday':

                            $closeAllDay = $row->closeAllDay;
                            if ($closeAllDay)
                            {
                                $form->satCloseAllDay->setValue($closeAllDay);

                                $form->satOpen->setValue($row->open);
                                $form->satClose->setValue($row->close);
                            }

                            break;


                    }

                    $this->view->form = $form;

                }
                //
                //
                //	    echo '<pre>';
                //        print_r(  $row   );
                //        echo '</pre>';
                //
                //        die('DEBUG');
            }
        }

        $form->name->setValue($Technician->Name);


        $Technicianservices = new Application_Model_Technicianservices();

        $technicianallservices = $Technicianservices->select()->where('technicianID=' .
            $technicianID)->query()->fetchAll(Zend_Db::FETCH_OBJ);


        $rows = $technicianallservices;
        if (is_array($rows))
        {

            foreach ($rows as $row)
            {

                $TechnicianServicesId[] = $row->serviceID;
            }
        }


        $Services = new Application_Model_Services();

        $servicesArr = $Services->fetchAll()->toArray();

        //      technicianID 	serviceID 	id


        if ($TechnicianServicesId)
        {
            for ($i = 0; $i < count($servicesArr); $i++)
            {

                $ServiceID = $servicesArr[$i]['serviceID'];
                if (in_array($ServiceID, $TechnicianServicesId))
                {

                    $servicesArr[$i]['checked'] = 1;
                }

            }

        } else
        {
            //  $servicesArr=$
        }


        //
        //	    echo '<pre>';
        //        print_r(  $TechnicianServicesId    );
        //        echo '</pre>';
        //
        //	    echo '<pre>';
        //        print_r(  $servicesArr   );
        //        echo '</pre>';
        //
        //        die('DEBUG');

        $this->view->Services = $servicesArr;


        $this->view->form = $form;

    }


    public function deleteTechnicianAction()
    {


        $Technician = new Application_Model_Technician();

        $Technicianhours = new Application_Model_Technicianhours();


        $Technicianservices = new Application_Model_Technicianservices();

        $id = $this->_getParam('id');


        $Technician->delete('technicianID=' . $id);


        $Technicianhours->delete("technicianID=" . $id);


        $Technicianservices->delete("technicianID=" . $id);


        $this->_helper->FlashMessenger->setNamespace('success')->addMessage('Technician is deleted Successfully');

        $this->_redirect("manage/employees");

    }

    public function addTechnicianAction()
    {
        $form = new Application_Form_Technician();
        $this->view->form = $form;

        $Services = new Application_Model_Services();
        $this->view->Services = $Services->fetchAll()->toArray();


        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData))
            {
                $Technician = new Application_Model_Technician();

                $u_data = array(

                    'name' => $form->getValue('name'),
                    'status' => '1',
                    );
                $Technician->insert($u_data);

                $select = $Technician->select()->from($Technician)->order('technicianID desc');

                $technicianid = $Technician->fetchRow($select)->toArray();

                $Technicianhours = new Application_Model_Technicianhours();

                //                if($form->getValue('sunCloseAllDay')) :

                $sundata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Sunday',
                    'closeAllDay' => $form->getValue('sunCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('sunOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('sunClose')),

                    );


                $Technicianhours->insert($sundata);

                //                      endif;

                //if($form->getValue('monCloseAllDay')) :

                //////// for monday
                $mondata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Monday',
                    'closeAllDay' => $form->getValue('monCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('monOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('monClose')),

                    );


                $Technicianhours->insert($mondata);

                //  endif;

                //   if($form->getValue('tueCloseAllDay')) :

                $tuedata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Tuesday',
                    'closeAllDay' => $form->getValue('tueCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('tueOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('tueClose')),

                    );


                $Technicianhours->insert($tuedata);

                //  endif;

                //       if($form->getValue('wedCloseAllDay')) :

                $weddata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Wednesday',
                    'closeAllDay' => $form->getValue('wedCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('wedOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('wedClose')),

                    );


                $Technicianhours->insert($weddata);
                //  endif;

                // if($form->getValue('thusCloseAllDay')) :


                $thusdata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Thursday',
                    'closeAllDay' => $form->getValue('thusCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('thusOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('thusClose')),

                    );


                $Technicianhours->insert($thusdata);


                //endif;

                //if($form->getValue('friCloseAllDay')) :
                $fridata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Friday',
                    'closeAllDay' => $form->getValue('friCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('friOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('friClose')),

                    );

                $Technicianhours->insert($fridata);

                //endif;

                //if($form->getValue('satCloseAllDay')) :


                $satdata = array(

                    'technicianID' => $technicianid['technicianID'],
                    'day' => 'Saturday',
                    'closeAllDay' => $form->getValue('satCloseAllDay'),
                    'open' => $this->timeConversion12hTO24h($form->getValue('satOpen')),
                    'close' => $this->timeConversion12hTO24h($form->getValue('satClose')),

                    );


                $Technicianhours->insert($satdata);

                //endif;    

                $form->reset();
                //$this->_redirect('manage/services');

                // now populate emplyoee service table


                $Technicianservices = new Application_Model_Technicianservices();

                //      technicianID 	day 	closeAllDay 	open 	close 	date 	open_time_id 	close_time_id
                $rows = $formData['service'];

                $Technicianservicedata['technicianID'] = $technicianid['technicianID'];

                //
                //	    echo '<pre>';
                //        print_r(  $rows   );
                //        echo '</pre>';
                //  
                //        die('DEBUG');
                //
                if (is_array($rows))
                {

                    foreach ($rows as $row)
                    {

                        $Technicianservicedata['serviceID'] = $row;
                        //
                        //	    echo '<pre>';
                        //        print_r(  $Technicianservicedata   );
                        //        echo '</pre>';
                        //
                        //        die('DEBUG');
                        $Technicianservices->insert($Technicianservicedata);

                    }
                }

                $this->_helper->FlashMessenger->setNamespace('success')->addMessage('Technitian is Created Successfully');
                $form->reset();
                $this->_redirect('manage/employees');

                $this->view->successMsg = "Service Added Successfully";

            } else
            {
                $form->populate($formData);

            }
        } else
        {
            // $TechniciansList = new Application_Model_Technician();
            // $result = $TechniciansList->fetchAll(

            //   'TechnicianID ='$this->_request->getParam('TechnicianID')

            //                           )->toArray();
            // $form->populate($result);
        }

    }


    public function getCouponAction()
    {
        $form = new Application_Form_Coupons();

        if (My_Auth::getInstance()->isVIPMember())
        {


        }

    }

    public function downloadVipcouponAction()
    {
        $form = new Application_Form_Coupons();

        if (My_Auth::getInstance()->isVIPMember())
        {

            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $file=APPLICATION_PATH."/../public/coupons/vip-coupon.pdf";
            
            if ( file_exists($file) ){
             //   die ('ok');
            } else {
               //  die ('not ok');
            }
            
            header('Content-type: application/pdf');

            // It will be called downloaded.pdf
            header('Content-Disposition: attachment; filename="download.pdf"');

            // The PDF source is in original.pdf
            readfile($file);

        }


    }

    public function couponsAction()
    {
        $form = new Application_Form_Coupons();

        if (My_Auth::getInstance()->isVIPMember())
        {


            $form->removeElement('vipfile');
        }


        $this->view->form = $form;

        if ($this->_request->isPost())
        {

            $formData = $this->_request->getPost();

            if ($form->isValid($formData))
            {


                $uploadedData = $form->getValues();


                echo "Coupon Uploaded!";


            } else
            {

                $form->populate($formData);

            }
        }

        $this->view->form = $form;
    }


    public function deleteCustomShopHoursAction()
    {
        $shopcustomhours = new Application_Model_Shopcustomhours();
        $ID = $this->_request->getParam('ID');
        $where = "ID = '$ID'";
        $shopcustomhours->delete($where);
        $this->_redirect('manage/shop-hours');


    }

    public function deleteServiceAction()
    {

        $shopcustomhours = new Application_Model_Services();
        $ID = $this->_request->getParam('id');
        $where = "serviceID = '$ID'";
        $shopcustomhours->delete($where);
        $this->_redirect('manage/services');

    }

    public function timeConversion24hTO12h($time_24h)
    {
        // 24-hour time to 12-hour time
        return $time_in_12_hour_format = date("g:i a", strtotime($time_24h));

    }
    public function timeConversion12hTO24h($time_12h)
    {
        // 12-hour time to 24-hour time
        return $time_in_24_hour_format = date("H:i", strtotime($time_12h));

    }

}
