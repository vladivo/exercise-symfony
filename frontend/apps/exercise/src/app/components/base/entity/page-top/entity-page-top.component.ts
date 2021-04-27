import {Component, Input} from '@angular/core';

@Component({
  selector: 'app-entity-page-top',
  templateUrl: './entity-page-top.component.html',
})
export class EntityPageTopComponent {
  @Input() public title!: string;
}
