import {Component, EventEmitter, Input, Output} from '@angular/core';
import {Entity} from "../../../../model/entity/entity";

@Component({
  selector: 'app-entity-page-bottom',
  templateUrl: './entity-page-bottom.component.html',
})
export class EntityPageBottomComponent {
  @Input() public entity!: Entity;
  @Input() public isForm!: boolean;
  @Output() public save: EventEmitter<void> = new EventEmitter();
}
