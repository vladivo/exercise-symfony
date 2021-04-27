import {ErrorHandler, NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {AppComponent} from './app.component';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {RouterModule, Routes} from "@angular/router";
import {HttpClientModule} from "@angular/common/http";
import {AlertService} from "./services/error/alert.service";
import {AppErrorHandler} from "./services/error/app-error-handler";
import {NavService} from "./services/nav/nav.service";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {UserClientService} from "./services/user/user-client.service";
import {EntityComponentMapperService} from "./services/entity/entity-component-mapper.service";
import {EntityHostDirective} from "./directives/entity-host.directive";
import {EntityClientService} from "./services/entity/entity-client.service";
import {EntityComponentFactory} from "./services/entity/entity-component-factory";
import {PermissionPreviewComponent} from "./components/entity/permission/preview/permission-preview.component";
import {PermissionFullComponent} from "./components/entity/permission/full/permission-full.component";
import {PermissionFormComponent} from "./components/entity/permission/form/permission-form.component";
import {HomePageComponent} from "./components/page/home/home-page.component";
import {UserPageComponent} from "./components/page/user/user-page.component";
import {UserProfileComponent} from "./components/user/profile/user-profile.component";
import {UserLoginComponent} from "./components/user/login/user-login.component";
import {UserLogoutComponent} from "./components/user/logout/user-logout.component";
import {UserResetPasswordComponent} from "./components/user/reset-password/user-reset-password.component";
import {UserUpdatePasswordComponent} from "./components/user/update-password/user-update-password.component";
import {UserLoginOnetimeComponent} from "./components/user/login-onetime/user-login-onetime.component";
import {NotFoundPageComponent} from "./components/page/not-found/not-found-page.component";
import {ErrorComponent} from "./components/base/header/error/error.component";
import {HeaderComponent} from "./components/base/header/header.component";
import {NavComponent} from "./components/base/header/nav/nav.component";
import {EntityActionsComponent} from "./components/base/entity/actions/entity-actions.component";
import {RolePreviewComponent} from "./components/entity/role/preview/role-preview.component";
import {RoleFormComponent} from "./components/entity/role/form/role-form.component";
import {RoleFullComponent} from "./components/entity/role/full/role-full.component";
import {AccountFormComponent} from "./components/entity/account/form/account-form.component";
import {AccountFullComponent} from "./components/entity/account/full/account-full.component";
import {AccountPreviewComponent} from "./components/entity/account/preview/account-preview.component";
import {EntityViewPageComponent} from "./components/page/entity/view/entity-view-page.component";
import {EntityDeletePageComponent} from "./components/page/entity/delete/entity-delete-page.component";
import {EntityViewConfigResolverService} from "./services/entity/entity-view-config-resolver.service";
import {EntityPageBottomComponent} from "./components/base/entity/page-bottom/entity-page-bottom.component";
import {EntityPageTopComponent} from "./components/base/entity/page-top/entity-page-top.component";
import {PermissionsService} from "./services/user/permissions.service";
import {RolesService} from "./services/user/roles.service";
import {CheckboxGroupComponent} from "./components/base/form/checkbox-group/checkbox-group.component";
import {UserRegisterComponent} from "./components/user/register/user-register.component";

const routes: Routes = [
  {path: '', component: HomePageComponent},
  {path: 'entity/:type', component: EntityViewPageComponent},
  {path: 'entity/:type/add', component: EntityViewPageComponent},
  {path: 'entity/:type/:id', component: EntityViewPageComponent},
  {path: 'entity/:type/:id/edit', component: EntityViewPageComponent},
  {path: 'entity/:type/:id/delete', component: EntityDeletePageComponent},
  {path: 'user', component: UserPageComponent,
    children: [
      {path: '', redirectTo: 'user/profile', pathMatch: 'full' },
      {path: 'register', component: UserRegisterComponent},
      {path: 'login', component: UserLoginComponent},
      {path: 'logout', component: UserLogoutComponent},
      {path: 'profile', component: UserProfileComponent},
      {path: 'password/reset', component: UserResetPasswordComponent},
      {path: 'password/update', component: UserUpdatePasswordComponent},
      {path: 'login/onetime/:token', component: UserLoginOnetimeComponent},
    ],
  },
  {path: '**', component: NotFoundPageComponent},
];

@NgModule({
  declarations: [
    AppComponent,
    EntityHostDirective,
    EntityActionsComponent,
    EntityPageBottomComponent,
    EntityPageTopComponent,
    CheckboxGroupComponent,
    ErrorComponent,
    NavComponent,
    HeaderComponent,
    EntityViewPageComponent,
    EntityDeletePageComponent,
    HomePageComponent,
    NotFoundPageComponent,
    UserPageComponent,
    UserProfileComponent,
    UserLoginComponent,
    UserLogoutComponent,
    UserRegisterComponent,
    UserResetPasswordComponent,
    UserUpdatePasswordComponent,
    UserLoginOnetimeComponent,
    AccountFormComponent,
    AccountFullComponent,
    AccountPreviewComponent,
    PermissionFormComponent,
    PermissionFullComponent,
    PermissionPreviewComponent,
    RoleFormComponent,
    RoleFullComponent,
    RolePreviewComponent,
  ],
  imports: [
    HttpClientModule,
    RouterModule.forRoot(routes),
    BrowserModule.withServerTransition({appId: 'serverApp'}),
    NgbModule,
    ReactiveFormsModule,
    FormsModule,
  ],
  providers: [
    AlertService,
    NavService,
    UserClientService,
    EntityClientService,
    EntityComponentFactory,
    EntityComponentMapperService,
    EntityViewConfigResolverService,
    PermissionsService,
    RolesService,
    {provide: ErrorHandler, useClass: AppErrorHandler}
  ],
  bootstrap: [AppComponent],
})
export class AppModule {
}
