import {Component} from '@angular/core';
import {EntityComponent} from "../../../../model/entity-component/entity-component";
import {Account} from "../../../../model/entity/account";

@Component({
  selector: 'app-account-preview',
  templateUrl: './account-preview.component.html',
})
export class AccountPreviewComponent implements EntityComponent {
  public entity!: Account;
}
