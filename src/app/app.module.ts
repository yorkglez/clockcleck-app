import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule } from '@angular/core';


import {RouterModule} from '@angular/router';
import {HttpClientModule} from '@angular/common/http';

import { ReactiveFormsModule, FormsModule} from '@angular/forms';
import { AppComponent } from './app.component';
import { LoginComponent } from './components/login/login.component';
import { AdminComponent } from './components/admin/admin/admin.component';
import { HomeComponent } from './components/admin/home/home.component';
import { AuthService } from './services/auth.service';

/*guards*/
import { AuthGuard } from './auth.guard';
import { AdminGuard } from './guards/admin.guard';
import { UserGuard } from './guards/user.guard';
import { TeacherGuard } from './guards/teacher.guard';
import { ValidGuard } from './guards/valid.guard';
import { GuestGuard } from './guards/guest.guard';

import { NavadminComponent } from './components/admin/shared/navadmin/navadmin.component';
import { UserService } from './services/user.service';
import { TeacherService } from './services/teacher.service';
import { LogoutComponent } from './components/shared/logout/logout.component';
import { UsersComponent } from './components/admin/users/users/users.component';
import { NgSelectModule } from '@ng-select/ng-select';
//import {PopoverModule} from 'ngx-bootstrap';

import { CreateUserComponent } from './components/admin/users/create-user/create-user.component';
import { EditUserComponent } from './components/admin/users/edit-user/edit-user.component';
import { CreateTeacherComponent } from './components/admin/teachers/create-teacher/create-teacher.component';
import { EditTeacherComponent } from './components/admin/teachers/edit-teacher/edit-teacher.component';
import { TeachersComponent } from './components/admin/teachers/teachers/teachers.component';
import { SearchUsersComponent } from './components/admin/users/search-users/search-users.component';
import { ReportsComponent } from './components/admin/reports/reports/reports.component';
import { UsersTableComponent } from './components/admin/users/shared/users-table/users-table.component';
import { UserFormComponent } from './components/admin/users/shared/user-form/user-form.component';
import { NgxPaginationModule } from 'ngx-pagination';
import { CarersComponent } from './components/admin/carers/carers/carers.component';
import { CreateCarersComponent } from './components/admin/carers/create-carers/create-carers.component';
import { EditCarersComponent } from './components/admin/carers/edit-carers/edit-carers.component';
import { SubjectsComponent } from './components/admin/subjects/subjects/subjects.component';
import { CreateSubjectComponent } from './components/admin/subjects/create-subject/create-subject.component';
import { EditSubjectComponent } from './components/admin/subjects/edit-subject/edit-subject.component';
import { ExtensionsComponent } from './components/admin/extensions/extensions/extensions.component';
import { CreateExtensionsComponent } from './components/admin/extensions/create-extensions/create-extensions.component';
import { NavteacherComponent } from './components/teacher/shared/navteacher/navteacher.component';
import { HomeTeacherComponent } from './components/teacher/home-teacher/home-teacher.component';
import { PorfileTeacherComponent } from './components/teacher/porfile-teacher/porfile-teacher.component';
import { ScheduleTeacherComponent } from './components/teacher/schedule-teacher/schedule-teacher.component';
import { AcademicloadTeacherComponent } from './components/teacher/academicload-teacher/academicload-teacher.component';
import { ConfigsComponent } from './components/admin/configs/configs.component';
import { AcademicloadlistComponent } from './components/admin/academicloadlist/academicloadlist.component';
import { ConfirmemailComponent } from './components/shared/confirmemail/confirmemail.component';
import { ResetpasswordComponent } from './components/shared/resetpassword/resetpassword.component';
import { LogininputComponent } from './components/shared/logininput/logininput.component';
import { LoginteacherComponent } from './components/teacher/loginteacher/loginteacher.component';
import { EditacademicloadComponent } from './components/teacher/editacademicload/editacademicload.component';
import { AlertsComponent } from './components/shared/alerts/alerts.component';
import { EditextensionComponent } from './components/admin/extensions/editextension/editextension.component';
import { PopoverModule } from 'ngx-popover';
import { ForgotpasswordComponent } from './components/shared/forgotpassword/forgotpassword.component';
import { PorfileComponent } from './components/shared/porfile/porfile.component';
import { LoaderComponent } from './components/shared/loader/loader.component';
//     import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
// import {ToastModule} from 'ng6-toastr/ng2-toastr';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    AdminComponent,
    HomeComponent,
    NavadminComponent,
    LogoutComponent,
    UsersComponent,
    CreateUserComponent,
    EditUserComponent,
    CreateTeacherComponent,
    EditTeacherComponent,
    TeachersComponent,
    SearchUsersComponent,
    ReportsComponent,
    UsersTableComponent,
    UserFormComponent,
    CarersComponent,
    CreateCarersComponent,
    EditCarersComponent,
    SubjectsComponent,
    CreateSubjectComponent,
    EditSubjectComponent,
    ExtensionsComponent,
    CreateExtensionsComponent,
    NavteacherComponent,
    HomeTeacherComponent,
    PorfileTeacherComponent,
    ScheduleTeacherComponent,
    AcademicloadTeacherComponent,
    ConfigsComponent,
    AcademicloadlistComponent,
    ConfirmemailComponent,
    ResetpasswordComponent,
    LogininputComponent,
    LoginteacherComponent,
    EditacademicloadComponent,
    AlertsComponent,
    EditextensionComponent,
    ForgotpasswordComponent,
    PorfileComponent,
    LoaderComponent,
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    HttpClientModule,
    ReactiveFormsModule,
    FormsModule,
    NgSelectModule,
    NgxPaginationModule,
    ReactiveFormsModule,
    PopoverModule,
    // BrowserAnimationsModule,
    // ToastModule.forRoot(),
    RouterModule.forRoot([{
      path:'hom',
      component: HomeComponent
    },
    {
      path:'login',
      component: LoginComponent,
      canActivate: [GuestGuard]
    },
    {
      path:'logout',
      component: LogoutComponent
    },
    {
      path:'homeadmin',
      component: AdminComponent,
      // canActivate: [AuthGuard]
    },
    //Admin
    {
      path:'users',
      component: UsersComponent,
      canActivate: [AdminGuard]
    },
    {
      path:'createuser',
      component: CreateUserComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'searchuser/:ter',
      component: SearchUsersComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'edituser/:id',
      component: EditUserComponent,
      canActivate: [AdminGuard]
    },
    {
      path:'teachers',
      component: TeachersComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'createteacher',
      component: CreateTeacherComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'editteacher/:id',
      component: EditTeacherComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'carers',
      component: CarersComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'createcarer',
      component: CreateCarersComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'editcarer/:id',
      component: EditCarersComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'subjects',
      component: SubjectsComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'createsubject',
      component: CreateSubjectComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'editsubject/:id',
      component: EditSubjectComponent,
      canActivate: [AdminGuard]

    },
    {
      path:'extensions',
      component: ExtensionsComponent,
      canActivate: [AdminGuard]
    },
    {
      path:'createextension',
      component: CreateExtensionsComponent,
      canActivate: [AdminGuard]
    },
    {
      path:'editextension/:id',
      component: EditextensionComponent,
      canActivate: [AdminGuard]
    },
    {
      path:'reports',
      component: ReportsComponent,
      canActivate: [AdminGuard,UserGuard]
    },
    {
      path:'porfile',
      component: PorfileComponent,
      canActivate: [AdminGuard,UserGuard]
    },
    {
      path:'academicloadlist',
      component: AcademicloadlistComponent,
      canActivate: [AdminGuard]
    },
    {
      path:'config',
      component: ConfigsComponent,
      canActivate: [AdminGuard]
    },
    //teacher
    {
      path:'hometeacher',
      component: HomeTeacherComponent,
      canActivate: [TeacherGuard]
    },
    {
      path:'scheduleteacher',
      component: ScheduleTeacherComponent,
      canActivate: [TeacherGuard]
    },
    {
      path:'porfileteacher',
      component: PorfileTeacherComponent,
      canActivate: [TeacherGuard]
    },
    {
      path:'academicloadteacher',
      component: AcademicloadTeacherComponent,
      canActivate: [TeacherGuard]
    },
    {
      path:'loginteacher',
      component: LoginteacherComponent,

    },
    {
      path:'editcacademicload',
      component: EditacademicloadComponent,

    },
    //users

    //shared
    {
      path:'confirmemail/:type/:token/:id/:action',
      component: ConfirmemailComponent,
      canActivate: [ValidGuard]
    },
    {
      path:'resetpassword',
      component: ResetpasswordComponent,
      canActivate: [ValidGuard]
    },
    {
      path:'forgotpassword',
      component: ForgotpasswordComponent,
      canActivate: [ValidGuard],
      data: { title: 'My Calendar' }
    }


    ])
  ],
  providers: [AuthService, UserService, TeacherService, AuthGuard,AdminGuard,UserGuard,TeacherGuard,ValidGuard,GuestGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
